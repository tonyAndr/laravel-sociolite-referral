<?php

namespace App\Listeners;

use App\Events\WithdrawalAutomaticallyPaid;
use App\Models\User;
use App\Notifications\WithdrawalAutoPaidToAdmin;

class WithdrawalPaidNotifyAdmin
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
    public function handle(WithdrawalAutomaticallyPaid $event): void
    {
        //
        $withdrawal_data = $event->data;

        $admins = User::where('is_admin', 1)->get();
        foreach ($admins as $key => $admin) {
            $admin->notify(new WithdrawalAutoPaidToAdmin($withdrawal_data));
        }

        
    }

}
