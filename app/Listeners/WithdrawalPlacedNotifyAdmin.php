<?php

namespace App\Listeners;

use App\Events\WithdrawalPlaced;
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

        $admins = User::where('is_admin', 1)->get();
        foreach ($admins as $key => $admin) {
            $admin->notify(new WithdrawalRequestedToAdmin($withdrawal_data));
        }
        
    }

}
