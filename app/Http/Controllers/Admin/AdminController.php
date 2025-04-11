<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard() {
        $user = Auth::user();
        return view('pages.admin.dashboard', compact('user'));
    }
}
