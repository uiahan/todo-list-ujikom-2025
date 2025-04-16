<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubtaskWorkerHistory extends Model
{
    use HasFactory;
    protected $fillable = ['subtask_worker_id', 'status', 'description', 'image', 'reset_at'];
}
