<?php

namespace App\Livewire;

use App\Models\Giveaway;
use Livewire\Component;
use App\Models\User;

class LastGiveawayWinners extends Component
{

    public function render()
    {
        $giveaways = Giveaway::latest()->take(10)->get();
        $winners = [];
        foreach ($giveaways as $key => $ga) {
            # code...
            if ($ga->winner_id) {
                $user = User::find($ga->winner_id);
                if ($user) {
                    $winners[]= ['name' => $user->name, 'reward' => $ga->reward];
                }
            }
            
        }

        return view('livewire.last-giveaway-winners')->with('winners', $winners);
    }
}
