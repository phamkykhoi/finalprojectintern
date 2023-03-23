<?php

namespace App\Observers;

use App\Models\Discussion;

class DiscussionObserver
{
    public static $currentUser = null;

    public function __construct()
    {
        self::$currentUser = auth()->user();
    }

    public function created(Discussion $discussion)
    {
        activity()->by(self::$currentUser)
            ->on($discussion)
            ->withProperties(['task_id' => $discussion->task_id])
            ->log(self::$currentUser->name.' đã bình luận');
    }

    public function updated(Discussion $discussion)
    {
        activity()->by(self::$currentUser)
            ->on($discussion)
            ->withProperties(['task_id' => $discussion->task_id])
            ->log(self::$currentUser->name.' đã sửa bình luận '.$discussion->getOriginal('description').' thành '.$discussion->description);
    }

    public function deleted(Discussion $discussion)
    {
        activity()->by(self::$currentUser)
            ->on($discussion)
            ->withProperties(['task_id' => $discussion->task_id])
            ->log(self::$currentUser->name.' đã xóa bình luận '.$discussion->description);
    }

    public function restored(Discussion $discussion)
    {
        //
    }

    public function forceDeleted(Discussion $discussion)
    {
        //
    }
}
