<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;

class ResetDailySubtasks extends Command
{
    protected $signature = 'reset:daily-subtasks';
    protected $description = 'Reset subtask worker status to pending for daily repeating tasks';

    public function handle(): void
    {
        $tasks = Task::where('repetition', 'daily')->with('subtasks.subtask_workers')->get();

        foreach ($tasks as $task) {
            foreach ($task->subtasks ?? [] as $subtask) {
                foreach ($subtask->subtask_workers ?? [] as $worker) {
                    $worker->update(['status' => 'pending']);
                }
            }
        }

        $this->info('Daily subtasks reset to pending.');
    }
}
