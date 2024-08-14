<?php

namespace App\Notifications;

use App\Models\MasterTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class UserTaskRemind extends Notification
{

    public MasterTask $task;

    public function __construct(MasterTask $task = null) {
        $this->task = $task;
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
            ->line("Незабудь закончить задание ".$this->task->title." на сайте, иначе не получишь награду. Срок скоро истечет!")
            ->button('Список заданий', route('dashboard'));

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
