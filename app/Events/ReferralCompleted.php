<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReferralCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * A referral where occurs current event.
     *
     */
    public $referral;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Referral  $referral
     * @return void
     */
    public function __construct(Referral $referral)
    {
        $this->referral = $referral;
    }
}
