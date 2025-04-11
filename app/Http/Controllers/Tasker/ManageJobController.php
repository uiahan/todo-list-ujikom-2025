<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageJobController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('pages.tasker.job.index', compact('user'));
    }
}
