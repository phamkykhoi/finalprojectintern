<?php

namespace App\Repositories;

use App\Models\TaskGroup;

class TaskGroupRepository extends BaseRepository
{
    public function __construct(TaskGroup $model)
    {
        $this->model = $model;
    }

    public function getByActivityId($activityId, array $withRelation = [])
    {
        $query = $this->model->where('activity_id', $activityId);

        if ($withRelation) {
            $query->with($withRelation);
        }

        return $query->get();
    }
}
