<?php

namespace App\Repositories;

use App\Models\UserActivity;

class UserActivityRepository extends BaseRepository
{
    public function __construct(UserActivity $model)
    {
        $this->model = $model;
    }

    public function existLeader($activityId)
    {
        return $this->model->where([
            'activity_id' => $activityId,
            'role_activity' => 1, // Chủ hoạt động
        ])->exists();
    }

    public function assignMember($userId, $activityId, $role)
    {
        $query = $this->model->where([
            'user_id' => $userId,
            'activity_id' => $activityId,
        ]);

        if ($query->count() > 0) {
            return $query->update(['role_activity' => $role]);
        }

        return $this->model->create([
            'user_id' => $userId,
            'activity_id' => $activityId,
            'role_activity' => $role,
        ]);
    }

    public function removeMember($userId, $activityId)
    {
        return $this->model->where([
            'user_id' => $userId,
            'activity_id' => $activityId,
        ])->delete();
    }
}
