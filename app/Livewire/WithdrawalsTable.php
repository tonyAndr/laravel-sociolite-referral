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
        // $route_uri = Route::current()->uri;

        $withdrawals = Withdrawal::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(15, pageName: 'withdrawals');

        return view('livewire.withdrawals-table', ['withdrawals' => $withdrawals]);
    }
}
