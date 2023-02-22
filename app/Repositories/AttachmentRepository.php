<?php

namespace App\Repositories;

use App\Models\Attachment;

class AttachmentRepository extends BaseRepository
{
    public function __construct(Attachment $model)
    {
        $this->model = $model;
    }

    public function getAttachmentsById($id)
    {
        return $this->model->where('attachable_id', $id)->get();
    }
}
