<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\App;
use App\Notifications\ChannelPostInviteFriends;

class RemindToInviteFriends extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remind-to-invite-friends';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get all active user tasks
        Notification::route('telegram', App::environment('local') ? env('TELEGRAM_CHANNEL_DEV_ID') : env('TELEGRAM_LUCHBUX_CHANNEL_LIVE_ID'))->notify(new ChannelPostInviteFriends());
        $this->info('New tasks notification sent');
    }
}
