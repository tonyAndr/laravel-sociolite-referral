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

class PaysupportCommand extends UserCommand
{

    /** @var string Command name */
    protected $name = 'paysupport';
    /** @var string Command description */
    protected $description = '';
    /** @var string Usage description */
    protected $usage = '/paysupport';
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

        $data['chat_id'] = $chat_id;
        $data['text'] = "Не удовлетворены качеством выполнения задач? \nТогда вы можете отправить задачу на проверку модератором командой /proverka либо запросить возврат звёзд командой /refund. \n\nВыполнение задачи может занять несколько часов или дней, в зависимости от заказаного объема рефералов. Проверьте статус задачи командой /task прежде чем запрашивать проверку. \n\nКогда задача будет завершена - мы сообщим вам сообщением в телеграме, а задача получит статус *finished*.";
        
        $data['parse_mode'] = 'markdown';

        return Request::sendMessage($data);
    }
}
