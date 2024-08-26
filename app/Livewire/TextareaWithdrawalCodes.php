<?php

namespace App\Livewire;

use Exception;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class TextareaWithdrawalCodes extends Component
{
    public $codes;
    public $num_left = 0;

    public function mount () {

        if (Storage::exists('codes.txt')) {
            $this->codes = Storage::get('codes.txt');
            try {
                $this->num_left = count(explode(PHP_EOL, trim($this->codes)));
            } catch (Exception $e) {
                $this->num_left = 0;
            }
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
