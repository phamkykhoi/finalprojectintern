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

    public function checkRelation($id)
    {
        return $this->model->find($id)->tasks()->exists();
    }

    public function copyTaskGroup($id)
    {
        $taskGroup = $this->model->find($id);
        $newTaskGroup = $taskGroup->replicate();
        $newTaskGroup->push();
        $taskGroup->load('tasks');
        $relations = $taskGroup->getRelations();

        foreach ($relations as $relation) {
            foreach ($relation as $relationRecord) {
                $newRelationship = $relationRecord->replicate();
                $newRelationship->task_group_id = $newTaskGroup->id;
                $newRelationship->push();
            }
        }
    }

    public function moveTaskGroup($id, $value)
    {
        $taskGroup1 = $this->model->find($id);
        $taskGroup2 = $this->model->find($value);
        $tempAttributes1 = $taskGroup1->getAttributes();
        $tempAttributes2 = $taskGroup2->getAttributes();
        $taskGroup1->update($tempAttributes2);
        $taskGroup2->update($tempAttributes1);
    }
}
