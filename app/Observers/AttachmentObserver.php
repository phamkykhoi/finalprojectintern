<?php

namespace App\Observers;

use App\Models\Attachment;

class AttachmentObserver
{
    public function created(Attachment $attachment)
    {
        $user = auth()->user(); 
        activity()->by($user)
            ->on($attachment)
            ->withProperties(['task_id' => $attachment->attachable_id])
            ->log($user->name.' đính kèm file '.$attachment->title );
    }

    public function updated(Attachment $attachment)
    {
        $user = auth()->user(); 
        activity()->by($user)
            ->on($attachment)
            ->withProperties(['task_id' => $attachment->attachable_id])
            ->log($user->name.' đã cập nhật file '.$attachment->title );
    }

    public function deleted(Attachment $attachment)
    {
        $user = auth()->user(); 
        activity()->by($user)
            ->on($attachment)
            ->withProperties(['task_id' => $attachment->attachable_id])
            ->log($user->name.' đã xóa file '.$attachment->title );
    }

    public function restored(Attachment $attachment)
    {
        //
    }

    public function forceDeleted(Attachment $attachment)
    {
        //
    }
}
