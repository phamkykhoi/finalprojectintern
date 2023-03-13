<?php

namespace App\Repositories;

use App\Models\Attachment;
use App\Models\Task;

class AttachmentRepository extends BaseRepository
{
    public function __construct(Attachment $model)
    {
        $this->model = $model;
    }

    public function getByTaskId($id)
    {
        return Task::find($id)->attachment;
    }

    public function updateAttachment($task, $listAttachments)
    {
        $this->model
        ->whereIn('id', $listAttachments)
        ->update(['attachable_id' => $task['id'], 'attachable_type' => $task['class']]);
    }
}
