<?php

namespace App\Observers;

use App\Models\Attachment;

class AttachmentObserver
{
    public static $currentUser = null;

    public function __construct()
    {
        self::$currentUser = auth()->user();
    }

    public function created(Attachment $attachment)
    {
        activity()->by(self::$currentUser)
            ->on($attachment)
            ->withProperties(['task_id' => $attachment->attachable_id])
            ->log(self::$currentUser->name.' đính kèm file '.$attachment->title );
    }

    public function updated(Attachment $attachment)
    {
       //
    }

    public function deleted(Attachment $attachment)
    {
        activity()->by(self::$currentUser)
            ->on($attachment)
            ->withProperties(['task_id' =>  intval($attachment->attachable_id)])
            ->log(self::$currentUser->name.' đã xóa file '.$attachment->title );
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
