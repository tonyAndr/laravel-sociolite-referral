<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\MasterTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class TaskReviewAdminTable extends Component
{
    use WithPagination;

    public $listeners = [
        'taskModified' => 'render',
    ];

    public function cancel($id)
    {
        

    }

    public function render()
    {
        $user = Auth::getUser();
        $route_uri = Route::current()->uri;

        $new_tasks = MasterTask::where('status', 'pre-review')->orderBy('created_at', 'desc')->paginate(15, pageName: 'taskreview');

        return view('livewire.task-review-admin-table', ['new_tasks' => $new_tasks]);
    }
}
