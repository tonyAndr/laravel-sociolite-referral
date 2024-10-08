<?php


namespace App\Telegram\Commands;

use Exception;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Illuminate\Support\Facades\Log;
use App\Telegram\Commands\CreateTaskCommand;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\InlineKeyboard;

class CallbackqueryCommand extends SystemCommand
{

    /** @var string Command name */
    protected $name = 'callbackquery';
    /** @var string Command description */
    protected $description = '';
    /** @var string Usage description */
    protected $usage = '/callbackquery';
    /** @var string Version */
    protected $version = '1.0.0';

    public function execute(): ServerResponse
    {
        // Callback query data can be fetched and handled accordingly.
        $callback_query = $this->getCallbackQuery();
        $callback_data  = $callback_query->getData();
        $chat_id = $callback_query->getMessage()->getChat()->getId();

        // Log::info(var_export($callback_query, true));

        if (strpos($callback_data, 'command_buy') !== false
        || strpos($callback_data, 'referral_service_') !== false) {
            $this->telegram->executeCommand('buymenu');
        }

        if (strpos($callback_data, 'referral_amount_') !== false) {
            $this->telegram->executeCommand('createtask');
        }
        if (strpos($callback_data, 'cancel_task_') !== false) {
            $task_id = explode('_', $callback_data)[2];
            CreateTaskCommand::cancelUnpaidTask($task_id);
        }
        if (strpos($callback_data, 'approve_task_no_invoice_') !== false) {
            $cb_info = explode('_', $callback_data);
            $task_id = end($cb_info);
            CreateTaskCommand::handleSuccessfulPayment($task_id, $chat_id);
        }

        if (strpos($callback_data, 'command_help') !== false) {
            $this->telegram->executeCommand('help');
        }

        return Request::deleteMessage([
            'chat_id' => $callback_query->getMessage()->getChat()->getId(),
            'message_id' => $callback_query->getMessage()->getMessageId(),
        ]);
    }

}
