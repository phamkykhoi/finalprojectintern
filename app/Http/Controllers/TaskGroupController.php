<?php

namespace App\Http\Controllers;

use App\Repositories\TaskGroupRepository;
use Illuminate\Http\Request;
use App\Http\Requests\TaskGroup\StoreTaskGroupRequest;

class TaskGroupController extends Controller
{
    protected $taskGroupRepo;

    public function __construct(
        TaskGroupRepository $taskGroupRepo
    )
    {
        $this->taskGroupRepo = $taskGroupRepo;
    }

    public function store(StoreTaskGroupRequest $request)
    {
        $this->taskGroupRepo->save($request->all());
    }
}
