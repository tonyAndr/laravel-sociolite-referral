<?php


namespace App\Telegram\Commands;


use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Conversation;

class MenuCommand extends UserCommand
{

    /** @var string Command name */
    protected $name = 'menu';
    /** @var string Command description */
    protected $description = '';
    /** @var string Usage description */
    protected $usage = '/menu';
    /** @var string Version */
    protected $version = '1.0.0';

    public function execute(): ServerResponse
    {

        // cancel prev conversations
                // Cancel current conversation if any
        $conversation = new Conversation(
            $this->getMessage()->getFrom()->getId(),
            $this->getMessage()->getChat()->getId()
        );

        if ($conversation_command = $conversation->getCommand()) {
            $conversation->cancel();
            // $text = 'Conversation "' . $conversation_command . '" cancelled!';
            $this->removeKeyboard('');
        }

        $keyboard = new InlineKeyboard(
            [
                ['text' => 'Купить рефералов', 'callback_data' => 'command_buy'],
            ],
            [
                ['text' => 'Помощь', 'callback_data' => 'command_help'],
            ],
            // [
            //     ['text' => $sl->get('buttons', 'menu_referral')],
            //     ['text' => $sl->get('buttons', 'menu_help')]
            // ],
        );
        $keyboard->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);

        return $this->replyToChat('Что выберем?', [
            'reply_markup' => $keyboard,
        ]);
    }

}
