<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Subtask;
use App\Models\SubtaskWorker;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PrivateJobController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $task = Task::where('created_by', $user->id)
            ->with([
                'subtasks.subtaskWorkers' => function ($query) use ($user) {
                    $query->where('worker_id', $user->id);
                }
            ])
            ->get()
            ->map(function ($t) use ($user) {
                $assignedSubtasks = $t->subtasks->filter(function ($subtask) use ($user) {
                    return $subtask->subtaskWorkers->isNotEmpty();
                });

                $doneCount = $assignedSubtasks->filter(function ($subtask) {
                    return $subtask->subtaskWorkers->first()?->status === 'done';
                })->count();

                $t->total_subtasks = $assignedSubtasks->count();
                $t->done_subtasks = $doneCount;
                return $t;
            });

        return view('pages.worker.private.private-job', compact('user', 'task'));
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

    public function delete($id)
    {
        $job = Task::findOrFail($id);
        $job->delete();

        return response()->json(['success' => 'Job successfully deleted.']);
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

    public function storeQuest(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'task_id' => 'required|exists:tasks,id',
        ]);

        $quest = Subtask::create([
            'title' => $validated['title'],
            'task_id' => $validated['task_id'],
        ]);

        return response()->json([
            'success' => true,
            'quest' => $quest
        ]);
    }

    public function getQuest(Task $task)
    {
        $quests = $task->subtasks;
        return response()->json($quests);
    }

    public function deleteQuest($id)
    {
        $quest = Subtask::findOrFail($id);
        $quest->delete();

        return response()->json([
            'success' => true,
            'message' => 'Quest successfully deleted.'
        ]);
    }

    public function privateQuest(Task $task)
    {
        $user = Auth::user();

        // Subtask yang belum pernah dikerjakan atau status-nya masih pending
        $subtasks = $task->subtasks()->where(function ($query) use ($user) {
            // Subtask yang belum dikerjakan sama sekali
            $query->whereDoesntHave('subtaskWorkers', function ($q) use ($user) {
                $q->where('worker_id', $user->id);
            });

            // ATAU, subtask yang pernah dikerjakan, tapi statusnya masih pending
            $query->orWhereHas('subtaskWorkers', function ($q) use ($user) {
                $q->where('worker_id', $user->id)
                    ->where('status', 'pending');
            });
        })->get();

        // Subtask yang statusnya in_progres
        $inProgress = $task->subtasks()->whereHas('subtaskWorkers', function ($query) use ($user) {
            $query->where('worker_id', $user->id)
                ->where('status', 'in_progres');
        })->get();

        $inReview = $task->subtasks()->whereHas('subtaskWorkers', function ($query) use ($user) {
            $query->where('worker_id', $user->id)
                ->where('status', 'review');
        })->get();

        $done = $task->subtasks()->whereHas('subtaskWorkers', function ($query) use ($user) {
            $query->where('worker_id', $user->id)
                ->where('status', 'done');
        })->get();

        $assignedSubtasks = $task->subtasks()->with([
            'subtaskWorkers' => function ($q) use ($user) {
                $q->where('worker_id', $user->id);
            }
        ])->whereHas('subtaskWorkers', function ($query) use ($user) {
            $query->where('worker_id', $user->id);
        })->get();

        $doneCount = 0;

        foreach ($assignedSubtasks as $subtask) {
            $worker = $subtask->subtaskWorkers->first();
            if ($worker && $worker->status === 'done') {
                $doneCount++;
            }
        }

        $totalSubtasks = $assignedSubtasks->count();
        $progress = $totalSubtasks > 0 ? min(100, ($doneCount / $totalSubtasks) * 100) : 0;

        return view('pages.worker.private.private-quest', compact('user', 'subtasks', 'inProgress', 'task', 'inReview', 'done', 'progress'));
    }

    public function done(Request $request)
    {
        $data = SubtaskWorker::where('subtask_id', $request->subtask_id)
            ->where('worker_id', $request->worker_id) // bukan auth()->id()
            ->latest()
            ->first();

        if (!$data) {
            return back()->with('error', 'Data tidak ditemukan!');
        }

        $data->update([
            'status' => 'done',
        ]);

        return back()->with('success', 'Quest done');
    }
}
