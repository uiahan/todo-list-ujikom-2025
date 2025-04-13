<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard() {
        $user = Auth::user();
        $taskerCount = User::where('role', 'tasker')->count();
        $workerCount = User::where('role', 'worker')->count();
        return view('pages.admin.dashboard', compact('user', 'taskerCount', 'workerCount'));
    }
}
