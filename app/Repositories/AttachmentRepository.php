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

    public function updateAttachmentByTaskId($request)
    {
        $this->model
        ->whereIn('id', $request->get('listAttachments'))
        ->update(['attachable_id' => $request->get('attachable_id'), 'attachable_type' => $request->get('attachable_type')]);
    }
}
