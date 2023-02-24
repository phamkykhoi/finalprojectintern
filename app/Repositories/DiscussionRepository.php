<?php

namespace App\Repositories;

use App\Models\Discussion;
use App\Models\Task;
use App\Models\TaskGroup;

class DiscussionRepository extends BaseRepository
{
    public function __construct(Discussion $model)
    {
        $this->model = $model;
    }

    public function getByTaskId($taskId)
    {
        return $this->model
        ->join('users', 'discussions.user_id', '=', 'users.id')
        ->select('discussions.*', 'users.name')
        ->where('task_id', $taskId)
        ->get();
    }

    public function deleteByTaskId($taskId, $userId)
    {
        Task::find($taskId)->discussions()->where('user_id', $userId)->delete();
    }
}
