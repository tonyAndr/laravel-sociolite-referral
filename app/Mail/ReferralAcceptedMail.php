<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Referral;

class ReferralAcceptedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * A user that sends an email.
     *
     */
    public $sender;

    /**
     * A referral URL link that is sent to the recipient.
     *
     */
    public $referral;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User $sender
     * @param  \App\Models\Referral $referral
     * @return void
     */
    public function __construct(User $sender, Referral $referral)
    {
        $this->sender = $sender;
        $this->referral = $referral;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->subject($this->sender->name . ' invited you.')
                ->markdown('emails.referrals.accepted');
    }
}