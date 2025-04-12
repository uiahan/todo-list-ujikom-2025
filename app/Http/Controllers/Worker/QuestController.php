<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('pages.worker.quest.index', compact('user'));
    }
}
