<?php

namespace App\Listeners;

use App\Events\WithdrawalApproved;
use App\Mail\WithdrawalApprovedMail;
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
