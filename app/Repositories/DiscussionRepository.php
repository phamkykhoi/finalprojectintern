<?php

namespace App\Repositories;

use App\Models\Discussion;

class DiscussionRepository extends BaseRepository
{
    public function __construct(Discussion $model)
    {
        $this->model = $model;
    }

    public function getDiscussionById()
    {
        
    }
}
