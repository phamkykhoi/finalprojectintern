<?php

namespace App\Listeners;

use App\Events\UploadFileSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Attachment;
use App\Models\Task;

class AssignAttachmentToTask
{
    protected $params;

    public function __construct()
    {
        //
    }

    public function handle(UploadFileSuccess $event): void
    {
        $event->attachment->attachable_type = Task::class;
        $event->attachment->attachable_id = $event->params['task_id'];
        $event->attachment->save();
    }
}
