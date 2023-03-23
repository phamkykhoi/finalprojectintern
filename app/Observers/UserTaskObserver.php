<?php

namespace App\Observers;

use App\Models\UserTask;

class UserTaskObserver
{
    public function created(UserTask $userTask)
    {
        $user = auth()->user(); 
        $userName = $userTask->user()->find($userTask->user_id)->name;
        $logMessage = $user->name;
        $logMessages = [
            5 => ' đã thêm '.$userName.' thành người theo dõi ',
            7 => ' đã thêm '.$userName.' thành người thực hiện ',
        ];
        
        if (array_key_exists($userTask->role_task, $logMessages)) {
            $logMessage .= $logMessages[$userTask->role_task];
        }
       
        activity()->by($user)
        ->on($userTask)
        ->withProperties(['task_id' => $userTask->task_id])
        ->log($logMessage);
    }

    public function updated(UserTask $userTask)
    {
        //
    }

    public function deleted(UserTask $userTask)
    {
        $user = auth()->user(); 
        $userName = $userTask->user()->find($userTask->user_id)->name;
        $logMessage = $user->name;
        $logMessages = [
            5 => ' đã hủy quyền theo dõi của ',
            7 => ' đã hủy gán việc cho ',
        ];
        
        if (array_key_exists($userTask->role_task, $logMessages)) {
            $logMessage .= $logMessages[$userTask->role_task].$userName;
        }
       
        activity()->by($user)
        ->on($userTask)
        ->withProperties(['task_id' => $userTask->task_id])
        ->log($logMessage);
    }

    public function restored(UserTask $userTask)
    {
        //
    }

    public function forceDeleted(UserTask $userTask)
    {
        //
    }
}
