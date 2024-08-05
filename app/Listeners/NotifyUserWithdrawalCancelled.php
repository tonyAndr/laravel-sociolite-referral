<?php

namespace App\Listeners;

use App\Events\WithdrawalCancelled;
use App\Mail\WithdrawalCancelledMail;
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
