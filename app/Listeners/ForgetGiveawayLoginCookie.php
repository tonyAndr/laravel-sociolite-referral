<?php

namespace App\Listeners;

class ForgetGiveawayLoginCookie
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        cookie()->queue(cookie()->forget('giveaway_login'));
    }
}
