<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ManageJobController extends Controller
{
    public function index() {
        $user = Auth::user();
        $task = Task::with('subtasks')->where('created_by', $user->id)->get();
        return view('pages.tasker.job.index', compact('user', 'task'));
    }

    public function viewJob() {
        $user = Auth::user();
        return view('pages.tasker.job.view-job', compact('user'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'video' => 'nullable|string',
                'deadline' => 'nullable',
                'repetition' => 'nullable'
            ]);
    
            $path = null;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('job-image', 'public');
            }

            $user = Auth::user();
    
            Task::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'image' => $path,
                'video' => $validated['video'],
                'deadline' => $validated['deadline'],
                'repetition' => $validated['repetition'],
                'created_by' => $user->id,
            ]);
            
            return redirect()->back()->with('success', 'Job successfully added.');
        } catch (ValidationException $e) {
            $firstError = collect($e->validator->errors()->all())->first();
            return redirect()->back()->with('error', $firstError);
        }
    }
}
