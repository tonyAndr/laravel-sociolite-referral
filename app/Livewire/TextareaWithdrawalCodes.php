<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class TextareaWithdrawalCodes extends Component
{
    public $codes;

    public function mount () {

        if (Storage::exists('codes.txt')) {
            $this->codes = Storage::get('codes.txt');
        } else {
            $this->codes = '';
        }
    }

    public function render()
    {
        return view('livewire.textarea-withdrawal-codes');
    }

    public function save() {
        
        $model = $this->only(['codes']);
        Storage::put('codes.txt', $model['codes']);
 
        session()->flash('status', 'Post successfully updated.');
    }
}
