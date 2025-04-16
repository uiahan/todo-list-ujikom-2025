<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\Subtask;
use App\Models\SubtaskWorker;
use App\Models\Task;
use Illuminate\Http\Request;

class ManageQuestController extends Controller
{
    public function store(Request $request)
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

    public function delete($id)
    {
        $quest = Subtask::findOrFail($id);
        $quest->delete();

        return response()->json([
            'success' => true,
            'message' => 'Quest successfully deleted.'
        ]);
    }

    public function approve(Request $request)
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
            'description' => $request->description,
        ]);

        return back()->with('success', 'Quest approved');
    }

    public function reject(Request $request)
    {
        $data = SubtaskWorker::where('subtask_id', $request->subtask_id)
            ->where('worker_id', $request->worker_id);

        if (!$data) {
            return back()->with('error', 'Data tidak ditemukan!');
        }

        $data->update([
            'status' => 'pending',
            'description' => $request->description,
        ]);

        return back()->with('success', 'Tugas dikembalikan ke pending');
    }


}
