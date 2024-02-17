<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class WithdrawalsTable extends Component
{
    use WithPagination;
    public function render()
    {
        $user = Auth::getUser();
        $route_uri = Route::current()->uri;

        if ($route_uri === 'withdrawal') {
            $withdrawals = Withdrawal::where('user_id', $user->id)->paginate(20, pageName: 'withdrawals');
        } else {
            $withdrawals = Withdrawal::paginate(20, pageName: 'withdrawals');
        }

        return view('livewire.withdrawals-table', ['withdrawals' => $withdrawals]);
    }
}
