<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Referral;

class WithdrawalApprovedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * A user that sends an email.
     *
     */
    public $comment;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User $sender
     * @param  \App\Models\Referral $referral
     * @return void
     */
    public function __construct(string|null $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject('Обновление по вашей заявке на вывод робуксов')
                ->markdown('emails.withdrawal-approved');
    }
}