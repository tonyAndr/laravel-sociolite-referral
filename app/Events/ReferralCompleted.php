<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReferralCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userToReward;

    public $invitedUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
}
