<?php

namespace App\Observers;

use App\Models\Discussion;

class DiscussionObserver
{
    public function created(Discussion $discussion)
    {
        $user = auth()->user(); 
        activity()->by($user)
            ->on($discussion)
            ->withProperties(['task_id' => $discussion->task_id])
            ->log($user->name.' đã bình luận');
    }

    public function updated(Discussion $discussion)
    {
        $user = auth()->user(); 
        activity()->by($user)
            ->on($discussion)
            ->withProperties(['task_id' => $discussion->task_id])
            ->log($user->name.' đã sửa bình luận '.$discussion->getOriginal('description').' thành '.$discussion->description);
    }

    public function deleted(Discussion $discussion)
    {
        $user = auth()->user(); 
        activity()->by($user)
            ->on($discussion)
            ->withProperties(['task_id' => $discussion->task_id])
            ->log($user->name.' đã xóa bình luận '.$discussion->description);
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
