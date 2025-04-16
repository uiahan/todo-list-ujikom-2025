<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index() {
        $user = Auth::user();
    
        $taskWorkers = TaskWorker::where('worker_id', $user->id)
            ->with(['task.subtasks.subtaskWorkers' => function ($query) use ($user) {
                $query->where('worker_id', $user->id);
            }])
            ->get();
    
        foreach ($taskWorkers as $tw) {
            $subtasks = $tw->task->subtasks ?? collect();
    
            $tw->total_subtasks = $subtasks->count();
            $tw->done_subtasks = $subtasks->filter(function ($subtask) use ($user) {
                return $subtask->subtaskWorkers->where('status', 'done')->where('worker_id', $user->id)->count() > 0;
            })->count();
        }
    
        return view('pages.worker.job.index', compact('user', 'taskWorkers'));
    }
    
}
