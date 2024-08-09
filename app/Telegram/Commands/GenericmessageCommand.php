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
 * Generic message command
 *
 * Gets executed when any type of message is sent.
 */

 namespace App\Telegram\Commands;

use App\Models\MasterTask;
use Longman\TelegramBot\Commands\SystemCommand;
use App\Telegram\Commands\InvoiceCommand;
use Longman\TelegramBot\Commands\UserCommands\CreateTaskCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Illuminate\Support\Facades\Log;

class GenericmessageCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'genericmessage';

    /**
     * @var string
     */
    protected $description = 'Handle generic message';

    /**
     * @var string
     */
    protected $version = '0.1.0';

    /**
     * Main command execution
     *
     * @return ServerResponse
     */
    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        $user_id = $message->getFrom()->getId();
        $chat_id = $message->getChat()->getId();

        // Handle successful payment
        if ($payment = $message->getSuccessfulPayment()) {
                // return InvoiceCommand::handleSuccessfulPayment($payment, $user_id);
            Log::info('Payment Success');
            // Log::info(var_export($payment, true));
            $task = MasterTask::find(intval($payment->invoice_payload));
            // set task status to pre-review
            // notify admins new task was created and paid
            // notify buyer that task is under review
            Request::deleteMessage([
                'chat_id'    => $chat_id,
                'message_id' => $task->invoice_msg_id,
            ]);
            return CreateTaskCommand::handleSuccessfulPayment($payment, $user_id);
        }

        return Request::emptyResponse();
    }
}