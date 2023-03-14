<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository extends BaseRepository
{
    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function getSubTasks($id = null) {
        return $this->model->select('*')->where('parent_id', $id)->get();
    }

    // public function getUser($id = null) {
    //     return $this->model->join('user_tasks', 'user_tasks.user_id', 'users.id')
    //             ->where('user_tasks.task_id', $id)->get();
    // }
}