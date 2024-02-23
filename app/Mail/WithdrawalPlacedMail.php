<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Referral;
use App\Models\Withdrawal;

class WithdrawalPlacedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $withdrawal;

    /**
     * Create a new message instance.
     *
     */
    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->subject('Новая заявка на вывод #' . $this->withdrawal->id)
                ->markdown('emails.withdrawal-placed');
    }
}