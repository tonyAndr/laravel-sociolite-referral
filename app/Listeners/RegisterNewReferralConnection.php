<?php

namespace App\Listeners;

use App\Events\ReferralDetected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Referral;

class RegisterNewReferralConnection
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
    public function handle(ReferralDetected $event): void
    {
        //
        Referral::create([
            'parent_id' => $event->referral,
            'child_id' => $event->invited->id
        ]);
    }
}
