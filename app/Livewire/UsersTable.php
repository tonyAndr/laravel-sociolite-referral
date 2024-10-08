<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\User;

class UsersTable extends Component
{
    use WithPagination;
    public function render()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20, pageName: 'users');
        return view('livewire.users-table', ['users' => $users]);
    }
}
