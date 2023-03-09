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

    public function updateAttachmentByTaskId($data)
    {
        $this->model
        ->whereIn('id', $data['listAttachments'])
        ->update(['attachable_id' => $data['attachable_id'], 'attachable_type' => $data['attachable_type']]);
    }
}
