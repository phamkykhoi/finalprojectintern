<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use App\Repositories\TaskGroupRepository;
use App\Repositories\UserTaskRepository;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    protected $taskRepo;

    protected $taskGroupRepo;

    protected $userTaskRepo;

    public function __construct(
        TaskRepository $taskRepo,
        TaskGroupRepository $taskGroupRepo,
        UserTaskRepository $userTaskRepo,
    ) {
        $this->taskRepo = $taskRepo;
        $this->taskGroupRepo = $taskGroupRepo;
        $this->userTaskRepo = $userTaskRepo;
    }

    public function store(CreateTaskRequest $request)
    {
        try {
            $taskId="";
            DB::transaction(function () use ($request, &$taskId) {
                $inputs = $request->all();
                $task = $this->taskRepo->save($inputs);
                $userTask = [
                    'user_id' => $inputs['user_id'],
                    'task_id' => $task['id'],
                    'role_task' => $inputs['role_id'],
                ];
                $taskId = $task['id'];
                $this->userTaskRepo->save($userTask);
            });
            return $this->success(['id' => $taskId]);

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function show($id)
    {
        return $this->success([
            'taskGroups' => $this->taskGroupRepo->getByActivityId($id, ['tasks']),
        ]);
    }

    public function update($id, UpdateTaskRequest $request)
    {
        try {
            $this->taskRepo->save($request->all(), ['id' => $id]);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

}
