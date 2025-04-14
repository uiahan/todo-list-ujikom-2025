<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskWorker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ManageJobController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $task = Task::with('subtasks')->where('created_by', $user->id)->get();
        return view('pages.tasker.job.index', compact('user', 'task'));
    }

    public function viewWorker(Task $task) {
        $user = Auth::user();
        $worker = User::where('role', 'worker')->get();
        $taskWorker = TaskWorker::where('task_id', $task->id)->with('worker')->get();
        return view('pages.tasker.job.worker-task', compact('user', 'worker', 'taskWorker', 'task'));
    }

    public function viewJob()
    {
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

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|string',
            'deadline' => 'nullable|date',
            'repetition' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($task->image && file_exists(storage_path('app/public/' . $task->image))) {
                unlink(storage_path('app/public/' . $task->image));
            }

            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath;
        }

        $task->update($validated);

        return redirect()->back()->with('success', 'Task updated successfully!');
    }


    public function delete($id)
    {
        $job = Task::findOrFail($id);
        $job->delete();

        return response()->json(['success' => 'Job successfully deleted.']);
    }

    public function storeWorker(Request $request)
    {
        try {
            $validated = $request->validate([
                'task_id' => 'required',
                'worker_id' => 'required',
            ]);

            TaskWorker::create([
                'task_id' => $validated['task_id'],
                'worker_id' => $validated['worker_id'],
            ]);

            return redirect()->back()->with('success', 'Worker assign successfully added.');
        } catch (ValidationException $e) {
            $firstError = collect($e->validator->errors()->all())->first();
            return redirect()->back()->with('error', $firstError);
        }
    }
}
