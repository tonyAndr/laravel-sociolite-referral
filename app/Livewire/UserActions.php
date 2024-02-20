<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserActions extends Component
{
    // public $rowData;

    // public function mount($rowData)
    // {
    //     $this->rowData = $rowData;
    // }

    // public function delete($id) {
    //     dd($id);
    //     $user = User::where('id', $id)->first();
    //     $user->delete();
    // }

    public function render()
    {
        return view('livewire.utilities.user-actions');
    }
}
