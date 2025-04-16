<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubtaskWorker extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function subtask()
    {
        return $this->belongsTo(Subtask::class);
    }

    // Relationship with Worker (many-to-one)
    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }





}
