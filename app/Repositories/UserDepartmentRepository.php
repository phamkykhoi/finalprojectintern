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
            'department_id' => $departmentId,
            'role' => 1, // Trưởng phòng
        ])->exists();
    }

    public function assignMember($userId, $departmentId, $role)
    {
        $query = $this->model->where([
            'user_id' => $userId,
            'department_id' => $departmentId,
        ]);

        if ($query->count() > 0) {
            return $query->update(['role' => $role]);
        }

        return $this->model->create([
            'user_id' => $userId,
            'department_id' => $departmentId,
            'role' => $role,
        ]);
    }

    public function removeMember($userId, $departmentId)
    {
        return $this->model->where([
            'user_id' => $userId,
            'department_id' => $departmentId,
        ])->delete();
    }
}
