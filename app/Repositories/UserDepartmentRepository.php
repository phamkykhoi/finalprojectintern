<?php

namespace App\Repositories;

use App\Models\UserDeparten;

class UserDepartmentRepository extends BaseRepository
{
    public function __construct(UserDeparten $model)
    {
        $this->model = $model;
    }

    public function existLeader($departmentId)
    {
        return $this->model->where([
            'departen_id' => $departmentId,
            'role' => 1, // Trưởng phòng
        ])->exists();
    }
}
