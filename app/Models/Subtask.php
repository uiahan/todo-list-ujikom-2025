<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function workers()
    {
        return $this->belongsToMany(User::class, 'subtask_workers')
            ->withPivot('status', 'description')
            ->withTimestamps();
    }

    public function subtask_workers()
    {
        return $this->hasMany(SubtaskWorker::class, 'subtask_id');
    }

    public function subtaskWorkers()
    {
        return $this->hasMany(SubtaskWorker::class);
    }

    public function workerStatus($workerId)
    {
        return $this->hasOne(SubtaskWorker::class)->where('worker_id', $workerId);
    }

}
