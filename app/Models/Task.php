<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function workers()
    {
        return $this->belongsToMany(User::class, 'task_workers', 'task_id', 'worker_id')
            ->withTimestamps();
    }
}
