<?php

namespace App\Listeners;

class ForgetReferralCookie
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        cookie()->queue(cookie()->forget('referral'));
    }
}
