<?php

/**
 * This file is part of the PHP Telegram Bot example-bot package.
 * https://github.com/php-telegram-bot/example-bot/
 *
 * (c) PHP Telegram Bot Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * User "/survey" command
 *
 * Example of the Conversation functionality in form of a simple survey.
 */

namespace App\Telegram\Commands;

use App\Http\Controllers\MasterTaskController;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\Entities\KeyboardButton;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\Payments\LabeledPrice;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\MasterTask;
use App\Models\User;
use App\Notifications\NotifyNewMasterTaskCreated;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;


class CreateTaskCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'createtask';

    /**
     * @var string
     */
    protected $description = 'Создание задания';

    /**
     * @var string
     */
    protected $usage = '/createtask';

    /**
     * @var string
     */
    protected $version = '0.4.0';

    /**
     * @var bool
     */
    protected $need_mysql = true;

    /**
     * @var bool
     */
    protected $private_only = true;

    /**
     * Conversation Object
     *
     * @var Conversation
     */
    protected $conversation;

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {

        $text = '';
        $chat = false;
        $user_id = false;
        $chat_id = false;
        $message = false;
        $callback_query= false;
        $product_id = false;
        $requested_amount = false;

        $callback_query = $this->getCallbackQuery();
        if ($callback_query) {
            $callback_data  = $callback_query->getData();
            Log::info(var_export($callback_data, true));
            $chat_id = $callback_query->getMessage()->getChat()->getId();
            $user_id = $callback_query->getMessage()->getChat()->getId();
            list($product_id, $requested_amount) = explode('_', str_replace('referral_amount_', '', $callback_data));
        }
        // Log::info(var_export($product_id, true));
        $message = $this->getMessage();

        if ($message) {

            $chat    = $message->getChat();
            $user    = $message->getFrom();
            $text    = trim($message->getText(true));
            $chat_id = $chat->getId();
            $user_id = $user->getId();
        }

        // Preparing response
        $data = [
            'chat_id'      => $chat_id,
            // Remove any keyboard by default
            'reply_markup' => Keyboard::remove(['selective' => true]),
        ];

        if ($chat && ($chat->isGroupChat() || $chat->isSuperGroup())) {
            // Force reply is applied by default so it can work with privacy on
            $data['reply_markup'] = Keyboard::forceReply(['selective' => true]);
        }

        // Conversation start
        $this->conversation = new Conversation($user_id, $chat_id, $this->getName());

        // check if cancellation called TODO: Genericcommand
        if ($text && in_array($text, ['отмена','Отмена','Отменить','отменить','cancel','Cancel', 'menu', 'Menu', 'Меню' ,'меню','В меню','в меню', 'Back to Menu'])) {
            return $this->telegram->executeCommand('cancel');
        }

        // Load any existing notes from this conversation
        $notes = &$this->conversation->notes;
        !is_array($notes) && $notes = [];

        // Load the current state of the conversation
        $state = $notes['state'] ?? 0;

        if ($product_id !== false) {
            $notes['product_id'] = $product_id;
            $notes['requested'] = $requested_amount;
        }

        $result = Request::emptyResponse();

        // State machine
        // Every time a step is achieved the state is updated
        switch ($state) {
            case 0:
                if ($text === '' || strpos($text, 'http') === false) {
                    $notes['state'] = 0;

                    $this->conversation->update();
                    $keyboard = new Keyboard([['text' => 'Отмена']]);

                    // Config
                    $keyboard->setResizeKeyboard(true)
                        ->setOneTimeKeyboard(true)
                        ->setSelective(true);

                    $data['reply_markup'] = $keyboard;
                    $data['text'] = 'Напиши в чат одну реферальную ссылку:';

                    $result = Request::sendMessage($data);
                    break;
                }

                $notes['ref_url'] = $text;
                $text          = '';

                $this->conversation->update();

                // charge the buyer
                $product = Product::find(intval($notes['product_id']));
                if (is_null($product)) {
                    // why this happens?
                    return $this->telegram->executeCommand('cancel');
                }

                $ppr = $product->ppr; 
                $sum = intval($notes['requested']) * $ppr;
                
                // check buyers ref balance
                $balance_deduction = 0;
                $buyer_details = DB::table('bot_user')
                    ->where('id', '=', $user_id)
                    ->first();

                if ($buyer_details->balance > 0) {
                    if ($buyer_details->balance >= $sum) {
                        $balance_deduction = $sum;
                        $sum = 0;
                    } else {
                        $balance_deduction = $buyer_details->balance;
                        $sum = $sum - $buyer_details->balance;
                    }
                } 

                $master_task = new MasterTask();
                $master_task->buyer_id = $user_id;
                $master_task->requested = intval($notes['requested']);
                $master_task->price = $sum;
                $master_task->balance_deduction = $balance_deduction;
                $master_task->status = 'unpaid';
                $master_task->ref_url = $notes['ref_url'];
                $master_task->product_id = $product->id;
                $master_task->title = "Стань рефералом в $product->description"; 
                $master_task->proof_type = 'screenshot'; 
                $master_task->save();
                $master_task->refresh();

                // if ($this->telegram->isAdmin()) {
                //     $result = $this->createTaskAsAdmin($master_task);
                //     break;                
                // }

                if ($sum === 0) {
                    $result = $this->createTaskWithoutInvoce($data, $notes, $balance_deduction, $product, $master_task);
                } else {
                    $result = $this->createTaskInvoice($data, $notes, $sum, $balance_deduction, $product, $master_task);
                }
                $this->conversation->stop();
                break;

                // if ($text === '') {
                //     $notes['state'] = 1;
                //     $this->conversation->update();

                //     $data['text'] = '(Опционально) Комментарий';

                //     $result = Request::sendMessage($data);
                //     break;
                // }

                // $notes['surname'] = $text;
                // $text             = '';

        }

        return $result;
    }

    public static function cancelUnpaidTask($task_id) {
        $task = MasterTask::find(intval($task_id));
        if ($task) {
            $task->status = 'cancelled';
            $task->save();
        }
    }

    // don't charge me
    public function createTaskAsAdmin($master_task) {
        $master_task->status = 'active';
        $master_task->telegram_payment_charge_id = 'admin';
        $master_task->proof_type = 'screenshot';
        $master_task->save();
        $this->conversation->stop();
        $data['text'] = "Задача создана админом.";
        return Request::sendMessage($data);
    }

    // using only referral balance and avoid invoices
    public function createTaskWithoutInvoce($data, $notes, $balance_deduction, $product, $master_task) {
        $balance_deduction_msg = PHP_EOL."Учтен реф. баланс: $balance_deduction телеграм-звёзд";

        $data['text'] =  "💰 Покупка рефералов в $product->description". PHP_EOL ."🔗 Реф. ссылка: " . $notes['ref_url'] . PHP_EOL  . $balance_deduction_msg . PHP_EOL . $notes['requested'] . " рефералов будут стоить 0 телеграм-звёзд. ";

        $keyboard = new InlineKeyboard([
            ['text' => 'Подтвердить', 'callback_data' => 'approve_task_no_invoice_'.$master_task->id],
            ['text' => 'Отмена', 'callback_data' => 'cancel_task_'.$master_task->id]
        ]);
        $data['parse_mode'] = 'html';
        $keyboard->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);
        $data['reply_markup'] = $keyboard;
        return Request::sendMessage($data);
    }

    public function createTaskInvoice($data, $notes, $sum, $balance_deduction, $product, $master_task) {
        $data['text'] =  '';
        $balance_deduction_msg = '';
        if ($balance_deduction > 0) {
            $balance_deduction_msg = " (учтен реф. баланс: $balance_deduction)";
        }
        
        $labeled_price = new LabeledPrice(['label'=> $sum . ' звезд', 'amount'=> $sum]);
        $data['description'] = 'Необходимо оплатить ' . $sum . ' телеграм-звёзд. '.$balance_deduction_msg;
        $data['title'] = "Покупка " . $notes['requested'] ." рефералов в  $product->description";
        $data['payload'] = $master_task->id;
        $data['start_parameter'] = '';
        $data['currency'] = 'XTR';
        $data['provider_token'] = '';
        $data['prices'] = [
            $labeled_price
        ];
        $keyboard = new InlineKeyboard(
            new InlineKeyboardButton(['text'=> 'Заплатить', 'pay' => true]),
            [
            ['text' => 'Отмена', 'callback_data' => 'cancel_task_'.$master_task->id]
        ]);
        $keyboard->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);
        $data['reply_markup'] = $keyboard;
        $result = Request::sendInvoice($data);
        Log::info(var_export($result, true));
        // save to remove the message later from chat
        $master_task->invoice_msg_id = $result->getResult()->getMessageId();
        $master_task->save();
        
        return $result;
    }

    public static function handleSuccessfulPayment($task_id, $user_id, $telegram_payment_charge_id = null) {
        $task_id = intval($task_id);

        $task = MasterTask::find(intval($task_id));
        if (!is_null($task)) {
            $task->status = 'active'; // leave "pre-review" to enable moderation
            if ($telegram_payment_charge_id) {
                $task->telegram_payment_charge_id = $telegram_payment_charge_id;
            }
            $task->save();
            // notify the channel
            MasterTaskController::notifyChannelNewTask($task);
        }

        // deduct referral balance
        if ($task->balance_deduction > 0) {
            $buyer = DB::table('bot_user')
            ->where('id', '=', $user_id)
            ->first();
            $new_balance = $buyer->balance - $task->balance_deduction;
            $affected = DB::table('bot_user')
                ->where('id', $user_id)
                ->update(['balance' => $new_balance]);
        }

        // notify admins
        $admins = User::where('is_admin', 1)->get();
        foreach ($admins as $key => $admin) {
            $data['chat_id'] = $admin->oauth_id;
            $data['text'] = "Оплачена новая задача\n\nНазвание: ".$task->title."\nURL: ".$task->ref_url . "\nЦена: " . $task->price . "\nИспольз. реф. баланса: " .$task->balance_deduction;
            $keyboard = new InlineKeyboard(
                new InlineKeyboardButton(['text'=> 'Посмотреть в админке', 'url' => route('admin.index')]),
                [
            ]);
            $keyboard->setResizeKeyboard(true)
                ->setOneTimeKeyboard(true)
                ->setSelective(false);
            $data['reply_markup'] = $keyboard;
            Request::sendMessage($data);
        }

        // notify the buyer
        if ($task->status === 'pre-review') {
            // notify the buyer of moderation
            $data = [];
            $data['chat_id'] = $user_id;
            $data['text'] = 'Ваша заявка отправлена на модерацию, ожидайте ответ от бота в ближайшее время.';
            return Request::sendMessage($data);
        }

        if ($task->status === 'active') {
            // notify approved directly
            self::handleApprove($task);
        }

        // update referral balances
        self::handleReferralReward($user_id, $task->price);
    }

    public static function handleApprove($task) {
        // notify the buyer
        $data = [];
        $data['chat_id'] = $task->buyer_id;
        $data['text'] = "Задача #$task->id принята в работу, мы сообщим когда она будет выполнена.";

        return Request::sendMessage($data);
    }
    
    public static function handleRefund($task) {
        // notify the buyer
        if ($task->telegram_payment_charge_id && $task->telegram_payment_charge_id !== 'admin') {
            // $data = [];
            // $data['chat_id'] = $task->buyer_id;
            // $data['telegram_payment_charge_id'] = $task->telegram_payment_charge_id;
            // Request::refundStarPayment($data);
            $telegram_payment_charge_id = trim($task->telegram_payment_charge_id);

            $response = Http::get("https://api.telegram.org/bot" . env('TELEGRAM_API_TOKEN') . "/refundStarPayment?user_id=$task->buyer_id&telegram_payment_charge_id=$telegram_payment_charge_id");
            $response_data = $response->json();

            if ($response_data["ok"]) {
                $data = [];
                $data['chat_id'] = $task->buyer_id;
                $data['text'] = "Был оформлен возврат, причина: \n" . $task->reason;
        
                return Request::sendMessage($data);
            }
        }

        return Request::emptyResponse();
    }

    public static function handleTaskProgress($task) {

        if ($task->fullfilled >= $task->requested) {
            $task->status = 'finished';
            $task->save();
            // notify the buyer
            $data = [];
            $data['chat_id'] = $task->buyer_id;
            $data['text'] = "Задача #$task->id выполнена.";
            Request::sendMessage($data);
    
            $admins = User::where('is_admin', 1)->get();
            foreach ($admins as $key => $admin) {
                # code...
                // if ($admin->oauth_id === 269324233) {
                //     continue;
                // }
                $data = [];
                $data['chat_id'] = $admin->oauth_id;
                $data['text'] = "Задача #$task->id завершена.";
                $keyboard = new InlineKeyboard(
                    new InlineKeyboardButton(['text'=> 'Посмотреть в админке', 'url' => route('admin.index')]),
                    [
                ]);
                $keyboard->setResizeKeyboard(true)
                    ->setOneTimeKeyboard(true)
                    ->setSelective(false);
                $data['reply_markup'] = $keyboard;
                Request::sendMessage($data);
            }
        }

    }

    // on payment update balances of the people who invited the user
    public static function handleReferralReward($buyer_id, $price) {
        $lvl1_reward = intval(round($price*0.25));

        $buyer = DB::table('bot_user')
                ->where('id', '=', $buyer_id)
                ->first();

        if ($buyer) {
            // get lvl 1 ref
            $lvl1_id = $buyer->ref_id;
            if ($lvl1_id) {
                $lvl1_user = DB::table('bot_user')
                ->where('id', '=', $lvl1_id)
                ->first();

                if ($lvl1_user) {
                    $affected = DB::table('bot_user')
                        ->where('id', $lvl1_id)
                        ->update(['balance' => ($lvl1_user->balance+$lvl1_reward)]);

                    // repeat for lvl2
                    // $lvl2_id = $lvl1_user->ref_id;
                    // if ($lvl2_id) {
                    //     $lvl2_user = DB::table('bot_user')
                    //     ->where('id', '=', $lvl2_id)
                    //     ->first();
        
                    //     if ($lvl2_user) {
                    //         $affected = DB::table('bot_user')
                    //             ->where('id', $lvl2_id)
                    //             ->update(['balance' => ($lvl2_user->balance+$lvl2_reward)]);
                    //     }
                    // }
                }
            }
        }
    }

    public function markdown_escape($text) {
        return str_replace([
          '\\', '-', '#', '*', '+', '`', '.', '[', ']', '(', ')', '!', '&', '<', '>', '_', '{', '}', '|'], [
          '\\\\', '\-', '\#', '\*', '\+', '\`', '\.', '\[', '\]', '\(', '\)', '\!', '\&', '\<', '\>', '\_', '\{', '\}', '\|',
        ], $text);
    }

}