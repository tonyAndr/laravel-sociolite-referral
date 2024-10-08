<?php

namespace App\Http\Controllers;

use App\Notifications\ChannelPostNewTask;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class MasterTaskController extends Controller
{
    //

    public static function notifyChannelNewTask()
    {
        // send post to the channel
        Notification::route('telegram', App::environment('local') ? env('TELEGRAM_CHANNEL_DEV_ID') : env('TELEGRAM_LUCHBUX_CHANNEL_LIVE_ID'))->notify(new ChannelPostNewTask());
    }
}
