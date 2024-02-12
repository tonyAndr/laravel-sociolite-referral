<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;

class ReferralDetected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * A referral where occurs current event.
     *
     */
    public $referral;
    

    /**
     * Invited and just created user
     *
     */
    public $invited;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Referral  $referral
     * @return void
     */
    public function __construct(string $referral_cookie, User $invited)
    {

        $this->referral = intval($referral_cookie);
        $this->invited = $invited;
    }
}
