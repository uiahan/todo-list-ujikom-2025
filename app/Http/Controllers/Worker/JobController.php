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
        $taskWorkers = TaskWorker::where('worker_id', Auth::id())->with('task')->get();
        return view('pages.worker.job.index', compact('user', 'taskWorkers'));
    }
}
