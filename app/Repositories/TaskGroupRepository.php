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

    public function copyTaskGroup($id)
    {
        $taskGroup = $this->model->find($id);
        $newTaskGroup = $taskGroup->replicate();
        $newTaskGroup->push();
        $taskGroup->relations = [];
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
        $swapTaskGroup = $this->model->find($value);
        $tempTaskGroup = $this->model->find($id);
        $this->model->find($id)->update([ 'name' => $swapTaskGroup->name, 'description' => $swapTaskGroup->description, 'activity_id' => $swapTaskGroup->activity_id, 'type' => $swapTaskGroup->type]);
        $swapTaskGroup->update([ 'name' => $tempTaskGroup->name, 'description' => $tempTaskGroup->description, 'activity_id' => $tempTaskGroup->activity_id, 'type' => $tempTaskGroup->type]);
    }
}
