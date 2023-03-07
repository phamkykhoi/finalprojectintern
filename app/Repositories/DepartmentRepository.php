<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository extends BaseRepository
{
    public function __construct(Department $model)
    {
        $this->model = $model;
    }

    public function getDepartments (array $withRelation = null, $userId = null)
    {
        $query = $this->model->select("departments.*")->join('user_departments', 'user_departments.department_id', 'departments.id');

        if ($userId) {
            $query->where('user_departments.user_id', $userId);
        }

        if ($withRelation) {
            $query->with($withRelation);
        }

        return $query->get();
    }
}
