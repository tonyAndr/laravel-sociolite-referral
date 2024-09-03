<?php


namespace App\Telegram\Commands;

use App\Models\MasterTask;
use App\Notifications\MasterTaskRejected;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Illuminate\Support\Facades\DB;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\InlineKeyboard;
use App\Models\User;
use App\Notifications\MasterTaskRefundRequest;

class RefundCommand extends UserCommand
{

    /** @var string Command name */
    protected $name = 'refund';
    /** @var string Command description */
    protected $description = '';
    /** @var string Usage description */
    protected $usage = '/refund';
    /** @var string Version */
    protected $version = '1.0.0';

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

    public function execute(): ServerResponse
    {
        // Get ref id
        $text = trim($this->getMessage()->getText(true));
        $user_id = $this->getMessage()->getFrom()->getId();
        $chat = $this->getMessage()->getChat();
        $chat_id = $this->getMessage()->getChat()->getId();

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
        $result = Request::emptyResponse();

        if ($state === 0 && $text && is_numeric($text)) {
            $task = false;
            if ($this->telegram->isAdmin()) {
                $task = MasterTask::where('id', intval($text))->first();
            } else {
                $task = MasterTask::where('id', intval($text))
                    ->where('buyer_id', $user_id)
                    ->first();
            }
            if ($task) {
                switch ($task->status) {
                    case 'active':
                        $msg = "Задача еще не завершена. Запросить возврат можно для завершенных задач.";
                        $this->conversation->stop();
                        break;
                    case 'rejected':
                        $msg = "Задача уже на проверке модератором. Ждите ответа...";
                        $this->conversation->stop();
                        break;
                    case 'finished': 
                        $msg = "Укажите причину возврата:";
                        $notes['task_id'] = $task->id;
                        $notes['state'] = 1;
                        $keyboard = new Keyboard([['text' => 'Отмена']]);

                        // Config
                        $keyboard->setResizeKeyboard(true)
                            ->setOneTimeKeyboard(true)
                            ->setSelective(true);

                        $data['reply_markup'] = $keyboard;
                        $this->conversation->update();
                        break;
                    default:
                        $msg = "Задача с номером #$text не обнаружена";
                        $this->conversation->stop();
                }

                $data['chat_id'] = $chat_id;
                $data['text'] = $msg;
                $data['parse_mode'] = 'html';
                $response = Request::sendMessage($data);
                return $response;
            } else {
                return $this->replyToChat('Задача с номером #' . $text . ' не обнаружена');
            }
        } else if ($state === 1 && $text) {
            $task = MasterTask::find($notes['task_id']);

            $task->status = 'pre-refund';
            $task->reason = $text;
            $task->save();
            $this->conversation->stop();

            // notify admins
            $admins = User::where('is_admin', 1)->get();
            foreach ($admins as $key => $admin) {
                $admin->notify(new MasterTaskRefundRequest($task));
            }

            $msg = "Заявка на возврат отправлена модераторам. Ожидайте ответа...";

            $data['chat_id'] = $chat_id;
            $data['text'] = $msg;
            $data['parse_mode'] = 'html';
            $response = Request::sendMessage($data);
            return $response;
        } else {
            return $this->replyToChat('Идентификатор задачи не обнаружен, после команды через пробел укажите номер задачи: /refund 123');
        }
    }
}
