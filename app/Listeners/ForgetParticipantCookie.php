<?php

namespace App\Listeners;

class ForgetParticipantCookie
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        cookie()->queue(cookie()->forget('participant'));
    }
}
