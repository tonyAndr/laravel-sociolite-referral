<?php

namespace App\Listeners;

use App\Events\ReferralCompleted;
use App\Events\ReferralDetected;
use App\Events\WithdrawalApproved;
use App\Mail\WithdrawalApprovedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Referral;
use Illuminate\Support\Facades\Mail;

class NotifyUserWithdrawalApproved
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
    public function handle(WithdrawalApproved $event): void
    {
        //
        $comment = null;
        Mail::to($event->data->getUser()->email)->send(new WithdrawalApprovedMail($comment));
    }
}
