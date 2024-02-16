<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Withdrawal;

class WithdrawalsTable extends Component
{
    use WithPagination;
    public function render()
    {
        $withdrawals = Withdrawal::paginate(20, pageName: 'withdrawals');
        return view('livewire.withdrawals-table', ['withdrawals' => $withdrawals]);
    }
}
