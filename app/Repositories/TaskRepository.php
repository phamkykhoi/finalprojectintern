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
        $newTask->completed_at = null;
        $newTask->is_important = false;
        $newTask->is_quickly = false;
        $newTask->start_date = null;
        $newTask-> end_date = null;
        $newTask->save();

        return $newTask;
    }

    public function lockTask($id)
    {
        $this->model->find($id)->update(['is_locked'=>true]);
    }

    public function unlockTask($id)
    {
        $this->model->find($id)->update(['is_locked'=>false]);
    }
}
