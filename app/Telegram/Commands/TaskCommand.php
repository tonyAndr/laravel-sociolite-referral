<?php


namespace App\Telegram\Commands;


use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Illuminate\Support\Facades\DB;

class TaskCommand extends UserCommand
{

    /** @var string Command name */
    protected $name = 'task';
    /** @var string Command description */
    protected $description = '';
    /** @var string Usage description */
    protected $usage = '/task';
    /** @var string Version */
    protected $version = '1.0.0';

    public function execute(): ServerResponse
    {
        // Get ref id
        $task_id = trim($this->getMessage()->getText(true));
        $user_id = $this->getMessage()->getFrom()->getId();
        $chat_id = $this->getMessage()->getChat()->getId();

        if ($task_id && is_numeric($task_id)) {
            $task = false;
            if ($this->telegram->isAdmin()) {
                $task = DB::table('master_tasks')
                    ->where('id', intval($task_id))
                    ->first();
            } else {
                $task = DB::table('master_tasks')
                ->where('id', intval($task_id))
                ->where('buyer_id', $user_id)
                ->first();
            }
            if ($task) {
                $msg = "Информация о задаче: ". PHP_EOL . PHP_EOL;
                $msg .= "<b>ID</b>: $task->id" . PHP_EOL;
                $msg .= "<b>Заказчик</b>: $task->buyer_id" . PHP_EOL;
                $msg .= "<b>Статус задачи</b>: $task->status" . PHP_EOL;
                $msg .= "<b>Создана</b>: $task->created_at" . PHP_EOL;
                $msg .= "<b>Реф. ссылка</b>: $task->ref_url" . PHP_EOL;
                $msg .= "<b>Запрошено реф.</b>: $task->requested" . PHP_EOL;
                $msg .= "<b>Получено реф.</b>: $task->fullfilled" . PHP_EOL;

                if ($task->telegram_payment_charge_id) {
                    $msg .= "<b>Идентификатор платежа</b>: $task->telegram_payment_charge_id" . PHP_EOL;  
                }

                if ($task->status === 'finished') {
                    $msg .= PHP_EOL . "<b>Действия:</b>";
                    $msg .= PHP_EOL . "<b>/proverka $task->id</b> - отправить на проверку модератору, если вы считаете, что задача не выполнена (или выполнена не в полном объеме)";
                }
                    
                $data['chat_id'] = $chat_id;
                $data['text'] = $msg;
                $data['parse_mode'] = 'html';
                $response = Request::sendMessage($data);
                return $response;
            } else {
                return $this->replyToChat('Задача с номером #' . $task_id . ' не обнаружена');
            }
        } else {
            return $this->replyToChat('Идентификатор задачи не обнаружен, после команды через пробел укажите номер задачи: /task 123');
        }
    }
}
