<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class ChannelPostWinnerDetails extends Notification
{

    public $reward;
    public $name;

    /**
     * Create a new notification instance.
     */
    public function __construct($reward, $name)
    {
        //
        $this->reward = $reward;
        $this->name = $name;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */ 
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {

        return TelegramMessage::create()
        //test channel -1002190632363
        //Notification::route('telegram', '-1002190632363')->notify(new \App\Notifications\ChannelPostWinnerDetails(100, 'his name'));
            // Markdown supported.
            ->content("🔥🔥🔥 Новый победитель бесплатной раздачи!\n\nНик победителя: *$this->name*\nНаграда: $this->reward РОБУСКОВ\n\n")
            ->line('Хочешь тоже выиграть? Жми сюда: '. route('giveaway'));
            // (Optional) Blade template for the content.
            // ->view('notification', ['url' => $url])

            // (Optional) Inline Buttons
            // ->button('Download Invoice', $url)
            // (Optional) Inline Button with callback. You can handle callback in your bot instance
            // ->buttonWithCallback('Confirm', 'confirm_invoice ' . $this->invoice->id);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
