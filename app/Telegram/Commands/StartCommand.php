<?php


namespace App\Telegram\Commands;


use Illuminate\Support\Facades\DB;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class StartCommand extends UserCommand
{

    /** @var string Command name */
    protected $name = 'start';
    /** @var string Command description */
    protected $description = 'Start';
    /** @var string Usage description */
    protected $usage = '/start';
    /** @var string Version */
    protected $version = '1.0.0';

    public function execute(): ServerResponse
    {

        // Get ref id
        $ref_id = trim($this->getMessage()->getText(true));
        $user_id = $this->getMessage()->getFrom()->getId();
        $chat_id = $this->getMessage()->getChat()->getId();

        if ($ref_id && is_numeric($ref_id) && intval($ref_id) !== $user_id) {
            $affected = DB::table('bot_user')
              ->where('id', $user_id)
              ->update(['ref_id' => intval($ref_id)]);
        }

        $this->replyToChat('Тебя приветствует бот для покупки ЖИВЫХ рефералов!');
        return $this->telegram->executeCommand('menu');
    }

}
