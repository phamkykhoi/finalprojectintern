<?php

namespace App\Repositories;

use App\Models\UserTask;

class UserTaskRepository extends BaseRepository
{
    public function __construct(UserTask $model)
    {
        $this->model = $model;
    }
}