<?php

namespace App\Listeners;

use App\Events\ReferralCompleted;
use App\Events\ReferralDetected;
use App\Events\WithdrawalCancelled;
use App\Mail\WithdrawalCancelledMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Referral;
use Illuminate\Support\Facades\Mail;

class NotifyUserWithdrawalCancelled
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WithdrawalCancelled $event): void
    {
        //
        Mail::to($event->email)->send(new WithdrawalCancelledMail($event->reason));
    }
}
