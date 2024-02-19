<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WithdrawalCancelled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Cancellation reason
     *
     */
    public $reason;

    /**
     * Users email
     *
     */
    public $email;

    /**
     * Create a new event instance.
     */
    public function __construct(string $reason, string $email)
    {
        //
        $this->reason = $reason;
        $this->email = $email;
    }

}
