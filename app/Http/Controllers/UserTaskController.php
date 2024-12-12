<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\MasterTask;
use App\Models\User;
use App\Models\UserTask;
use App\Notifications\UserTaskRejected;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Telegram\Commands\CreateTaskCommand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Log;

class UserTaskController extends Controller
{
    //
    // Task info page
    public function index(Request $request): View
    {
        $task_id = $request->get('id');
        $master_task = MasterTask::find(intval($task_id));
        $user = $request->user();
        $user_task = UserTask::where('user_id', $user->id)->where('master_task_id', $task_id)->first();
        $status = 'preview';
        $expires_min = false;
        if ($user_task) {
            $status = $user_task->status;
            // if active show all info, proof upload, finish/cancel buttons, etc
            // if finished, hide buttons

            // timeleft
            \date_default_timezone_set('Europe/Moscow');
            $now = now('Europe/Moscow');
            $exp = new \DateTime($user_task->expires_at);
            $diff = $now->diff($exp);
            $expires_min = $diff->i;
        }
        // if user_task not found then its just a preview page, limited info
        return view('tasks.user-task-view', ['task' => $master_task, 'user_status' => $status, 'expires_min' => $expires_min]);
    }

    public function endTask(Request $request): RedirectResponse {
        $params = $request->all();
        $user = $request->user();
        $task_id = $params['task_id'];
        $task = MasterTask::find(intval($task_id));
        $user_task = $task->usertasks->where('user_id', $user->id)->first();

        if ($user_task) {

            if ($user_task->status === 'cancelled') {
                // probably expired
                return Redirect::route('dashboard');
            }

            if (array_key_exists('action_finish', $params)) {
                // finish task
                // !!!TODO validation
                if ($task->proof_type === 'screenshot' || $task->proof_type === 'screenshot_nickname') {
                    $paths = [];
                    if ($request->hasFile('screenshots') ) {

                        $request->validate([
                            'screenshots' => [
                                'required',
                                File::image()
                                ->min('1kb')
                                ->max('3mb')
                            ]
                        ]);

                        if (is_array($request->file('screenshots'))) {
                            foreach ($request->file('screenshots') as $k => $scr) {
                                $path = $scr->store("$task_id/$user->id", 'public');
                                $paths[] = $path;
                            }
                        } else {
                            $path = $request->file('screenshots')->store("$task_id/$user->id", 'public');
                            $paths[] = $path;
                        }
                    }
                    $user_task->proof = implode(',', $paths);
                }
                if ($task->proof_type === 'screenshot_nickname') {
                    $user_task->service_nickname = $params['nickname'];
                }


                if ($task->proof_type === 'text') {
                    $user_task->proof = $params['text_proof'];
                }

                $user_task->status = 'finished';
                $user_task->save();

                // reward the user
                $user->addRobuxNoRef($task->user_reward);

                // tick the master task
                $task->fullfilled++;
                $task->save();
                $task->refresh();

                CreateTaskCommand::handleTaskProgress($task);
            } 
            if (array_key_exists('action_cancel', $params)) {
                // cancel task
                $user_task->delete();
            } 
        }

        return back();
    }

    public function start (Request $request): RedirectResponse {
        $params = $request->all();
        $user = $request->user();
        $task_id = $params['task_id'];
        $master_task = MasterTask::find(intval($task_id));

        $active_user_tasks = UserTask::where('master_task_id', $master_task->id)->where('status', 'active')->whereNot('user_id', $user->id)->get();
        $in_work_count = count($active_user_tasks);
        $progress = $master_task->fullfilled + $in_work_count;
        if ($progress < $master_task->requested) {
            $expires_at = $master_task->task_type === 0 ? now('Europe/Moscow')->addHour() : now('Europe/Moscow')->addMonth(); 
            $user_task = new UserTask([
                'master_task_id' => intval($task_id),
                'user_id' => $user->id,
                'expires_at' => $expires_at->toDateTimeString(),
                'product_id' => $master_task->product_id
            ]);
            $user_task->save();

            return back();
        }

        return Redirect::route('dashboard');
    }

    public function dashboard() : RedirectResponse
    {
        return Redirect::route('dashboard');
    }

    public static function reject($user_task_id) {
        $user_task = UserTask::find(intval($user_task_id));
        if ($user_task) {
            // ut status = rejected
            $user_task->status = 'rejected';
            $user_task->save();
            
            $master_task = MasterTask::find($user_task->master_task_id);

            // user balance decrease
            $user_id = $user_task->user_id;
            $user = User::find($user_id);
            $user->robux = $user->robux - $master_task->user_reward;
            $user->save();
            // send message task failed
            try {
                $user->notify(new UserTaskRejected($master_task));
            } catch (\NotificationChannels\Telegram\Exceptions\CouldNotSendNotification $e) {
                Log::error($e->getMessage());
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }

            // mt fullfilled--
            $master_task->fullfilled = $master_task->fullfilled - 1;
            $master_task->save();
        }
    }

}
