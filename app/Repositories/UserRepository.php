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
}