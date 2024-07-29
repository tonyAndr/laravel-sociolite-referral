<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class SendRobuxToUser extends Notification
{
    public $withdrawal;

    /**
     * Create a new notification instance.
     */
    public function __construct($withdrawal)
    {
        //
        $this->withdrawal = $withdrawal;
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
            // Optional recipient user id.
            ->to($notifiable->oauth_id)
            // Markdown supported.
            ->line("Заявка на вывод обработана")
            ->line("Робуксов запрошено: *". $this->withdrawal->amount . "*")
            ->line("Твой код для активации: *" . $this->withdrawal->redeem_code . "*")
            ->line("Введи код на официальном сайте для получения робуксов: https://www.roblox.com/redeem");

            // (Optional) Blade template for the content.
            // ->view('notification', ['url' => $url])

            // (Optional) Inline Buttons
            // ->button('View Invoice', $url)
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
