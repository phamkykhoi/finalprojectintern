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
}
