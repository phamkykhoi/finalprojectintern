<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAll(array $withRelation = null, $role_task = null)
    {
        $query = $this->model->leftJoin('user_tasks', 'users.id', '=', 'user_tasks.user_id')
        ->select('users.*', 'user_tasks.role_task');
        
        if ($withRelation) {
            $query->with($withRelation);
        }

        if($role_task) {
            $query->where(function($query) use ($role_task) {
                $query->where('role_task', $role_task)->orWhereNull('role_task');
            });
        }

        return $query->where('users.id', '!=', 1)->get();
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

    public function getMembersTask($id = null) {
        return $this->model->with('attachment')->join('user_tasks', 'user_tasks.user_id', 'users.id')
            ->where('user_tasks.task_id', $id)->get();
    }

}
