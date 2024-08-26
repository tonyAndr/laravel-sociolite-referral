<?php

namespace App\Livewire;

use App\Http\Controllers\GiveawayController;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On; 

class GiveawayCallToAction extends Component
{
    public User|bool $user;
    public $user_is_participating = false;
    public $user_subscribed = true;


    public function mount () {
        $user = Auth::user();
        if ($user) {
            $this->user = $user;
            $this->user_is_participating = $user->giveaway > 0;
        } else {
            $this->user = false;
        }
    }

    #[On('intervalSubscriptionCheck')] 
    public function intervalSubscriptionCheck()
    {
        if ($this->user) {
            $res = GiveawayController::checkSubscription($this->user->oauth_id, env('TELEGRAM_LUCHBUX_CHANNEL_LIVE_ID'));
            $this->user_subscribed = $res['result'];
        }
    }

    public function render()
    {
        
        return view('livewire.giveaway-call-to-action');
    }
}
