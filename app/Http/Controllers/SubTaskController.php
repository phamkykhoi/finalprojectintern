<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateSubTaskRequest;
use App\Http\Requests\Task\UpdateSubTaskRequest;
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

    public function update($id, UpdateSubTaskRequest $request)
    {
        try {
            $request->request->add(['description'=>'dcscasccs']);
            $this->taskRepo->save($request->all(), ['id' => $id]);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
