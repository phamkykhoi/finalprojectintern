<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    public static $currentUser = null;

    public function __construct()
    {
        self::$currentUser = auth()->user();
    }

    public function created(Task $task)
    {
        $logMessage = self::$currentUser->name;
        if ($task->parent_id === null) {
            $logMessage .= ' đã tạo việc '.$task->name;
        } else {
            $logMessage .= ' đã tạo việc con '.$task->name;
        }
        
        activity()->by(self::$currentUser)
        ->on($task)
        ->withProperties(['task_id' => $task->parent_id])
        ->log($logMessage);
    }

    public function updated(Task $task)
    {
        $logMessage = self::$currentUser->name;
        $taskId = $task->parent_id ?? $task->id;

        $logMessage .= ($task->parent_id === null)
        ? ($task->isDirty('name') ? ' đã đổi tên công việc '.$task->getOriginal('name').' thành '.$task->name : '')
        . ($task->isDirty('description') ? ' cập nhật mô tả việc '.$task->getOriginal('description').' thành '.$task->description : '')
        : '';

        $logMessage .= ($task->parent_id !== null)
        ? ($task->isDirty('name') ? ' đã đổi tên việc con '.$task->getOriginal('name').' thành '.$task->name : '')
        . ($task->isDirty('description') ? ' cập nhật mô tả việc con '.$task->getOriginal('description').' thành '.$task->description : '')
        : '';

        activity()->by(self::$currentUser)
        ->on($task)
        ->withProperties(['task_id' => $taskId])
        ->log($logMessage);
    }

    public function deleted(Task $task)
    {
        $logMessage = self::$currentUser->name;
        $taskId = $task->parent_id ?? $task->id;
        if ($task->parent_id === null) {
            $logMessage .= ' đã xóa công việc '.$task->name;
        } else {
            $logMessage .= ' đã xóa việc con '.$task->name;
        }
        
        activity()->by(self::$currentUser)
        ->on($task)
        ->withProperties(['task_id' => $taskId])
        ->log($logMessage);
    }

    public function restored(Task $task)
    {
        //
    }

    public function forceDeleted(Task $task)
    {
        //
    }
}
