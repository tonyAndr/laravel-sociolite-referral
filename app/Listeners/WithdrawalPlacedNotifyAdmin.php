<?php

namespace App\Listeners;

use App\Events\ReferralCompleted;
use App\Events\ReferralDetected;
use App\Events\WithdrawalCancelled;
use App\Events\WithdrawalPlaced;
use App\Mail\WithdrawalPlacedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Referral;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Notifications\WithdrawalRequestedToAdmin;

class WithdrawalPlacedNotifyAdmin
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
    public function handle(WithdrawalPlaced $event): void
    {
        //
        $withdrawal_data = $event->data;
        // $this->addRow($withdrawal_data);

        $admins = User::where('is_admin', 1)->get();
        foreach ($admins as $key => $admin) {
            $admin->notify(new WithdrawalRequestedToAdmin($withdrawal_data));
            // if ($admin->email) {
            //     Mail::to($admin->email)->send(new WithdrawalPlacedMail($withdrawal_data));
            // }
        }
    }

}
