<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TaskAssignedNotification extends Notification
{
    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['database']; // bisa ditambah mail kalau mau email juga
    }

    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'message' => "New job : " . $this->task->title,
        ];
    }
}

