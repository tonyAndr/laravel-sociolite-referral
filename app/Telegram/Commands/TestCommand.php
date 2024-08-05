<?php


namespace App\Telegram\Commands;


use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class TestCommand extends UserCommand
{

    /** @var string Command name */
    protected $name = 'test';
    /** @var string Command description */
    protected $description = '';
    /** @var string Usage description */
    protected $usage = '/test';
    /** @var string Version */
    protected $version = '1.0.0';

    public function execute(): ServerResponse
    {
        $callback_query = $this->getCallbackQuery();
        $chat_id = $callback_query->getMessage()->getChat()->getId();
        $data['chat_id'] = $chat_id;
        $data['text'] = 'Test text after callback';
        return Request::sendMessage($data);
    }

}
