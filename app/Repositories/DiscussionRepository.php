<?php

namespace App\Repositories;

use App\Models\Discussion;
use App\Models\Task;

class DiscussionRepository extends BaseRepository
{
    public function __construct(Discussion $model)
    {
        $this->model = $model;
    }

    public function getDiscussionById($id)
    {
        return $this->model
        ->join('users', 'discussions.user_id', '=', 'users.id')
        ->select('discussions.description', 'discussions.created_at', 'users.name')
        ->where('task_id', $id)
        ->get();
    }
}
