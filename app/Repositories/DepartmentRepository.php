<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository extends BaseRepository
{
    public function __construct(Department $model)
    {
        $this->model = $model;
    }

    public function getDepartments (array $withRelation = null) {
        $query = $this->model->join('user_departments', 'user_departments.department_id', 'departments.id')
        ->select("departments.*")
        ->where('user_departments.user_id',auth()->user()->id);
        if ($withRelation) {
            $query->with($withRelation);
        }
        return $query->get();
    }
}