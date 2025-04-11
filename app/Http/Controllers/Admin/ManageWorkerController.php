<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageWorkerController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('pages.admin.manage.worker', compact('user'));
    }
}
