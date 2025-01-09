<?php

namespace App\Listeners;

use App\Events\ReferralCompleted;
use App\Events\ReferralDetected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Referral;
use App\Models\User;
use App\Notifications\NotifyParentsRewardedReferrals;
use Illuminate\Support\Facades\Log;

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

            $exists = Referral::where('parent_id', $event->referral)->where('child_id', $event->invited->id)->first();

            if ($exists != null) {
                return;
            }
            $referral = Referral::firstOrCreate([
                'parent_id' => $event->referral,
                'child_id' => $event->invited->id
            ]);

            $parent = User::find($event->referral);

            if ($referral) {
                // to remove cookie
                event(new ReferralCompleted());
                // to reward the invitee
                $reward = 5;
                $parent->addRobuxNoRef($reward);
                if ($parent) {
                    $parent->notify(new NotifyParentsRewardedReferrals($reward, true));
                }
            }
        }
    }
}
