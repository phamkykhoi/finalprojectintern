<?php

namespace App\Listeners;

use App\Events\UploadFileSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Attachment;
use App\Models\Task;

class AssignAttachmentToTask
{
    /**
     * Create the event listener.
     *
     * @return void
     */
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
        $inputs = Attachment::find($event->attachment['id'])->getAttributes();
        $inputs['attachable_type'] = Task::class;
        Attachment::updateOrCreate(['id' => $inputs['id']], $inputs);
    }
}
