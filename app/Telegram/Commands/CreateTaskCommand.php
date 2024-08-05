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

namespace Longman\TelegramBot\Commands\UserCommands;

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

                    $data['text'] = 'Добавь реферальную ссылку';

                    $result = Request::sendMessage($data);
                    break;
                }

                $notes['ref_url'] = $text;
                $text          = '';

                $this->conversation->update();

                // charge the buyer
                $product = Product::find(intval($notes['product_id']));
                $ppr = $product->ppr; 
                $sum = intval($notes['requested']) * $ppr;

                $master_task = new MasterTask();
                $master_task->buyer_id = $chat_id;
                $master_task->requested = intval($notes['requested']);
                $master_task->price = $sum;
                $master_task->status = 'unpaid';
                $master_task->ref_url = $notes['ref_url'];
                $master_task->product_id = $product->id;
                $master_task->save();
                $master_task->refresh();

                $data['text'] =  '';
                
                $labeled_price = new LabeledPrice(['label'=> $sum . ' звезд', 'amount'=> $sum]);
                $data['description'] = $notes['requested'] . ' рефералов будут стоить ' . $sum . ' телеграм-звёзд. '.PHP_EOL.'Реф. ссылка: ' . $notes['ref_url'];
                $data['title'] = $product->description;
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
                Log::info(var_export($data, true));
                $result = Request::sendInvoice($data);
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
    public static function handleSuccessfulPayment($payment, $user_id) {
        $task_id = $payment->invoice_payload;
        $task = MasterTask::find(intval($task_id));
        if (!is_null($task)) {
            $task->status = 'pre-review';
            $task->save();
        }

        // notify admins
        $admins = User::where('is_admin', 1)->get();
        foreach ($admins as $key => $admin) {
            # code...
            // $admin->notify(new NotifyNewMasterTaskCreated());
            if ($admin->oauth_id === 269324233) {
                continue;
            }

            $data['chat_id'] = $admin->oauth_id;
            $data['text'] = 'Оплачена новая задача, см. в админке';
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
        $data = [];
        $data['chat_id'] = $user_id;
        $data['text'] = 'Ваша заявка отправлена на модерацию, ожидайте ответ от бота в ближайшее время.';
        return Request::sendMessage($data);
    }
    
    public static function handleRefund($task, $reason) {
        $task_id = $payment->invoice_payload;
        $task = MasterTask::find(intval($task_id));
        if (!is_null($task)) {
            $task->status = 'pre-review';
            $task->save();
        }

        // notify admins
        $admins = User::where('is_admin', 1)->get();
        foreach ($admins as $key => $admin) {
            # code...
            // $admin->notify(new NotifyNewMasterTaskCreated());
            if ($admin->oauth_id === 269324233) {
                continue;
            }

            $data['chat_id'] = $admin->oauth_id;
            $data['text'] = 'Оплачена новая задача, см. в админке';
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
        $data = [];
        $data['chat_id'] = $user_id;
        $data['text'] = 'Ваша заявка отправлена на модерацию, ожидайте ответ от бота в ближайшее время.';
        return Request::sendMessage($data);
    }

}