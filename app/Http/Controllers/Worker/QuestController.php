<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\SubtaskWorker;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestController extends Controller
{
    public function index(Task $task)
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

        $doneCount = $done->count();
        $totalSubtasks = $subtasks->count();

        $progress = $totalSubtasks > 0 ? ($doneCount / $totalSubtasks) * 100 : 0;

        return view('pages.worker.quest.index', compact('user', 'subtasks', 'inProgress', 'task', 'inReview', 'done', 'progress'));
    }

    public function questProgress(Request $request)
    {
        $request->validate([
            'subtask_id' => 'required|exists:subtasks,id',
            'worker_id' => 'required|exists:users,id',
        ]);

        // Cari subtask_worker berdasarkan subtask_id dan worker_id
        $subtaskWorker = SubtaskWorker::where('subtask_id', $request->subtask_id)
            ->where('worker_id', $request->worker_id)
            ->first();

        // Kalau udah ada, update status ke in_progres
        if ($subtaskWorker) {
            $subtaskWorker->status = 'in_progres';
            $subtaskWorker->save();
        } else {
            // Kalau belum ada, bikin data baru
            SubtaskWorker::create([
                'subtask_id' => $request->subtask_id,
                'worker_id' => $request->worker_id,
                'status' => 'in_progres',
            ]);
        }

        return back()->with('success', 'Subtask status berhasil diupdate.');
    }


    public function cancel(Request $request)
    {
        $request->validate([
            'subtask_id' => 'required|exists:subtasks,id',
            'worker_id' => 'required|exists:users,id',
        ]);

        // Cari subtask_worker berdasarkan subtask_id dan worker_id
        $subtaskWorker = SubtaskWorker::where('subtask_id', $request->subtask_id)
            ->where('worker_id', $request->worker_id)
            ->first();

        // Kalau ada, ubah statusnya jadi pending
        if ($subtaskWorker) {
            $subtaskWorker->status = 'pending';
            $subtaskWorker->save();
        }

        return back()->with('success', 'Subtask dikembalikan ke pending.');
    }

    public function updateToReview(Request $request)
    {
        // Validasi input
        $request->validate([
            'subtask_id' => 'required|exists:subtasks,id',
            'worker_id' => 'required|exists:users,id',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
        ]);

        // Cek apakah subtask_worker sudah ada
        $subtaskWorker = SubtaskWorker::where('subtask_id', $request->subtask_id)
            ->where('worker_id', $request->worker_id)
            ->first();


        if (!$subtaskWorker) {
            return back()->with('error', 'Subtask worker not found.');
        }

        // Simpan foto
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('photos', 'public');
            $subtaskWorker->image = $imagePath;
        }

        // Update status ke 'review'
        $subtaskWorker->status = 'review';
        $subtaskWorker->save();

        return back()->with('success', 'Subtask status updated to review.');
    }


}
