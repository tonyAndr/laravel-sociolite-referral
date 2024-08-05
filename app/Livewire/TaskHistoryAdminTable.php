<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\MasterTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class TaskHistoryAdminTable extends Component
{
    use WithPagination;

    public $listeners = [
        'taskModified' => 'render',
    ];

    public function render()
    {
        $user = Auth::getUser();
        $route_uri = Route::current()->uri;

        $new_tasks = MasterTask::whereIn('status', ['active', 'finished', 'denied', 'cancelled'])->orderBy('created_at', 'desc')->paginate(15, pageName: 'taskreview');

        return view('livewire.task-history-admin-table', ['new_tasks' => $new_tasks]);
    }
}
