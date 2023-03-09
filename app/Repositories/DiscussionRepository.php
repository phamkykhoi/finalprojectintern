<?php

namespace App\Repositories;

use App\Models\Discussion;

class DiscussionRepository extends BaseRepository
{
    public function __construct(Discussion $model)
    {
        $this->model = $model;
    }

    public function getByTaskId($taskId, $limit)
    {
        return $this->model
        ->join('users', 'discussions.user_id', '=', 'users.id')
        ->select('discussions.*', 'users.name')
        ->where('task_id', $taskId)
        ->latest()->paginate($limit);
    }
}
