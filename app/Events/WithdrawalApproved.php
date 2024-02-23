<?php

namespace App\Events;

use App\Models\Withdrawal;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WithdrawalApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Withdrawal object
     *
     */
    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct(Withdrawal $data)
    {
        //
        $this->data = $data;
    }

}
