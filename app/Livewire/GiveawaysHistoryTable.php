<?php

namespace App\Livewire;

use App\Models\Giveaway;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class GiveawaysHistoryTable extends Component
{
    use WithPagination;
    public function render()
    {

        $giveaways = Giveaway::orderBy('created_at', 'desc')->paginate(15, pageName: 'giveaways');

        return view('livewire.giveaways-history-table', ['giveaways' => $giveaways]);
    }
}
