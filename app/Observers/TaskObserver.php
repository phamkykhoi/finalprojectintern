<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    public function created(Task $task)
    {
        $user = auth()->user(); 
        $logMessage = $user->name;
        if ($task->parent_id === null) {
            $logMessage .= ' đã tạo việc '.$task->name;
        } else {
            $logMessage .= ' đã tạo việc con '.$task->name;
        }
        
        activity()->by($user)
        ->on($task)
        ->withProperties(['task_id' => $task->parent_id])
        ->log($logMessage);
    }

    public function updated(Task $task)
    {
        $user = auth()->user(); 
        $logMessage = $user->name;
        $taskId = $task->parent_id ?? $task->id;
        if ($task->parent_id === null) {
            $logMessage .= ' đã đổi tên công việc '.$task->getOriginal('name').' thành '.$task->name;
        } 
        
        if($task->isDirty('name')) {
            $logMessage .= ' đã cập nhật tên việc con'.$task->getOriginal('name').' thành '.$task->name;
        }

        if ($task->isDirty('description')) {
            $logMessage .= ' cập nhật mô tả việc con '.$task->getOriginal('description').' thành '.$task->description;
        }

        activity()->by($user)
        ->on($task)
        ->withProperties(['task_id' => $taskId])
        ->log($logMessage);
    }

    public function deleted(Task $task)
    {
        $user = auth()->user(); 
        $logMessage = $user->name;
        $taskId = $task->parent_id ?? $task->id;
        if ($task->parent_id === null) {
            $logMessage .= ' đã xóa công việc '.$task->name;
        } else {
            $logMessage .= ' đã xóa việc con '.$task->name;
        }
        
        activity()->by($user)
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
