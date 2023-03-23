<?php

namespace App\Repositories;

use App\Models\ActivityLog;

class ActivityLogRepository extends BaseRepository
{
    public function __construct(ActivityLog $model)
    {
        $this->model = $model;
    }

    public function getLogs(int $id = null)
    {
        return $this->model->select('*')->whereJsonContains('properties->task_id', $id)->get();
    }
}
