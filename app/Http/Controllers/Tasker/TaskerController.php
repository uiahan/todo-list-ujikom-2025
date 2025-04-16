<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskerController extends Controller
{
    public function dashboard() {
        $user = Auth::user();
        $jobCount = Task::where('created_by', $user->id)->count();
        return view('pages.tasker.dashboard', compact('user', 'jobCount'));
    }
}
