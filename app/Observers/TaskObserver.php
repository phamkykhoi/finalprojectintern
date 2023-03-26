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
    
        $logMessage .= $this->processTaskName($task);
        $logMessage .= $this->processTaskDescription($task);
        $logMessage .= $this->processTaskStatus($task);
        $logMessage .= $this->processTaskUrgent($task);
        $logMessage .= $this->processTaskImportant($task);
        $logMessage .= $this->processTaskLocked($task);
        $logMessage .= $this->processTaskTime($task);
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
    
    private function processTaskName($task)
    {
        $logMessage = '';
    
        $logMessage .= ($task->parent_id === null)
            ? ($task->isDirty('name') ? ' đã đổi tên công việc '.$task->getOriginal('name').' thành '.$task->name : '')
            : ($task->isDirty('name') ? ' đã đổi tên việc con '.$task->getOriginal('name').' thành '.$task->name : '');
    
        return $logMessage;
    }
    
    private function processTaskDescription($task)
    {
        $logMessage = '';
    
        $logMessage .= ($task->parent_id === null)
            ? ($task->isDirty('description') ? ' cập nhật mô tả việc '.$task->getOriginal('description').' thành '.$task->description : '')
            : ($task->isDirty('description') ? ' cập nhật mô tả việc con '.$task->getOriginal('description').' thành '.$task->description : '');
    
        return $logMessage;
    }
    
    private function processTaskStatus($task)
    {
        $logMessage = '';
    
        if ($task->isDirty('completed_at')) {
            if ($task->parent_id === null) {
                if ($task->completed_at != null) {
                    $logMessage .= ' đã hoàn thành công việc ';
                } else {
                    $logMessage .= ' bỏ hoàn thành việc ';
                }
            } else {
                if ($task->completed_at != null) {
                    $logMessage .= ' đã hoàn thành công việc con '.$task->name;
                } else {
                    $logMessage .= ' bỏ hoàn thành việc con '.$task->name;
                }
            }
        }
    
        return $logMessage;
    }

    private function processTaskUrgent($task)
    {
        $logMessage = '';
        $logMessage .= ($task->isDirty('is_quickly')) ? ($task->is_quickly ? ' đã chọn việc cần hoàn thành gấp' : ' bỏ chọn việc cần hoàn thành gấp') : '';
        return $logMessage;
    }

    private function processTaskImportant($task)
    {
        $logMessage = '';
        $logMessage .= ($task->isDirty('is_important')) ? ($task->is_important ? ' đã chọn việc quan trọng ' : ' bỏ chọn việc quan trọng ') : '';
        return $logMessage;
    }

    private function processTaskLocked($task)
    {
        $logMessage = '';
        $logMessage .= ($task->isDirty('is_locked')) ? ($task->is_locked ? ' khóa công việc ' : ' mở khóa công việc  ') : '';
        return $logMessage;
    }

    private function processTaskTime($task)
    {
        $logMessage = '';
        $logMessage .= ($task->isDirty('start_date'))
            ? (($task->start_date != null) ? ' thay đổi ngày bắt đầu '.$task->getOriginal('start_date').' thành '.$task->start_date : '')
                . (($task->start_date === null) ? ' đã thực hiện xóa ngày bắt đầu '.$task->start_date : '')
            : '';

        $logMessage .= ($task->isDirty('end_date'))
            ? (($task->end_date != null) ? ' thay đổi ngày kết thúc '.$task->getOriginal('end_date').' thành '.$task->end_date : '')
                . (($task->end_date === null) ? ' đã thực hiện xóa ngày kết thúc '.$task->end_date : '')
            : '';
        return $logMessage;
    }
}
