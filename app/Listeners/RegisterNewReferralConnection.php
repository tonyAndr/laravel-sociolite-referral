<?php

namespace App\Listeners;

use App\Events\ReferralCompleted;
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
        if (Referral::notFromSameUser($event->referral, $event->invited->id)) {
            $ref_conversely = Referral::where('parent_id', $event->invited->id)->where('child_id', $event->referral)->first();
            if ($ref_conversely) {
                return;
            }
            $referral = Referral::firstOrCreate([
                'parent_id' => $event->referral,
                'child_id' => $event->invited->id
            ]);

            if ($referral) {
                event(new ReferralCompleted());
            }
        }
    }
}
