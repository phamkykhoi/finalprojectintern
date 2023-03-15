<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository extends BaseRepository
{
    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function getSubTasks($id = null)
    {
        return $this->model->select('*')->where('parent_id', $id)->get();
    }

    public function cloneTask($id)
    {
       $newTask = $this->model->find($id)->replicate();
       $newTask->status = Task::STATUS['todo'];
       $newTask->save();
       return $newTask;
    }
}
