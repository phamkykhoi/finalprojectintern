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

    /**
     * Handle the event.
     *
     * @param  \App\Events\UploadFileSuccess  $event
     * @return void
     */
    public function handle(UploadFileSuccess $event): void
    {
        $event->attachment->attachable_type = Task::class;
        $event->attachment->attachable_id = json_decode($event->params)->task_id;
        Attachment::updateOrCreate(['id' => json_decode($event->params)->task_id], $event->attachment->getAttributes());
    }
}
