<?php


namespace App\Telegram\Commands;


use Illuminate\Support\Facades\DB;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\Keyboard;

class StartCommand extends UserCommand
{

    /** @var string Command name */
    protected $name = 'help';
    /** @var string Command description */
    protected $description = 'help';
    /** @var string Usage description */
    protected $usage = '/help';
    /** @var string Version */
    protected $version = '1.0.0';

    public function execute(): ServerResponse
    {

        // Get ref id
        $user_id = $this->getMessage()->getFrom()->getId();
        $chat_id = $this->getMessage()->getChat()->getId();

        $data['chat_id'] = $chat_id;
        $data['reply_markup'] = Keyboard::remove(['selective' => true]);


        $data['text'] = "Твой ID в телеграме: " . $user_id 
        . PHP_EOL . PHP_EOL
        . "В нашем боте ты можешь купить рефералов для любой крипто-игры или твоей произвольной ссылки."
        . PHP_EOL . PHP_EOL
        . "Приглашай людей и получай 10% от их покупок на свой баланс, или 1% от покупок рефералов 2-го уровня. "
        . PHP_EOL
        . "🔗 Ссылка для инвайтов:";
        Request::sendMessage($data);

        $data['text'] = "https://t.me/".env('TELEGRAM_BOT_USERNAME')."?start=" . $user_id;

        return Request::sendMessage($data);
    }

}
