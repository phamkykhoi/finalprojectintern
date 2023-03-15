<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAll(array $withRelation = null)
    {
        $query = $this->model->query();

        if ($withRelation) {
            $query->with($withRelation);
        }

        return $query->where('id', '!=', 1)->get();
    }

    public function getByDepartmentId($departmentId)
    {
        return $this->model->join('user_departments', 'user_departments.user_id', 'users.id')
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'user_departments.role'
            ])
            ->where('user_departments.department_id', $departmentId)
            ->get();
    }

    public function getUserTask($id = null) {
        $query =  $this->model->with('attachment')->join('user_tasks', 'user_tasks.user_id', 'users.id')
            ->where('user_tasks.task_id', $id);
        return $query->get();
    }
}
