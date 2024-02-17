<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class WithdrawalsAdminTable extends Component
{
    use WithPagination;
    public function render()
    {
        $user = Auth::getUser();
        $route_uri = Route::current()->uri;

        $withdrawals = Withdrawal::paginate(20, pageName: 'withdrawals');

        return view('livewire.withdrawals-admin-table', ['withdrawals' => $withdrawals]);
    }
}
