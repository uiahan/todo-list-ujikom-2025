<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkerController extends Controller
{
    public function dashboard() {
        $user = Auth::user();
        return view('pages.worker.dashboard', compact('user'));
    }
}
