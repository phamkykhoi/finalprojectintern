<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateSubTaskRequest;
use App\Repositories\TaskRepository;

class SubTaskController extends Controller
{

    protected $taskRepo;

    public function __construct(
        TaskRepository $taskRepo,
    ) {
        $this->taskRepo = $taskRepo;
    }


    public function store(CreateSubTaskRequest $request)
    {
        try {
            $this->taskRepo->save($request->all());
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function edit($subTaskId)
    {
        try {
            return $this->success(['subtask' => $this->taskRepo->findById($subTaskId)]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
