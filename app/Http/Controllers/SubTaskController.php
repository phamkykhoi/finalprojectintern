<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateSubTaskRequest;
use App\Http\Requests\Task\UpdateSubTaskRequest;
use App\Repositories\TaskRepository;
use Inertia\Inertia;

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

    public function edit($id)
    {
        try {
            return $this->success(['subtask' => $this->taskRepo->findById($id)]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function destroy($id)
    {
        try {
            $this->taskRepo->deleteById($id);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function update(UpdateSubTaskRequest $request, $id)
    {
        try {
            $this->taskRepo->save($request->all(), ['id' => $id]);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getSubTask($id) {
        return $this->success([
            'subtask' => $this->taskRepo->getSubTasks($id)
        ]);
    }
}
