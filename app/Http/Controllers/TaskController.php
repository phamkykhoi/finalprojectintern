<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use App\Repositories\TaskGroupRepository;
use App\Repositories\UserTaskRepository;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Requests\Task\CompletedTaskRequest;
use App\Models\Task;
use App\Repositories\UserRepository;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    protected $taskRepo;

    protected $taskGroupRepo;

    protected $userTaskRepo;

    protected $userRepo;

    public function __construct(
        TaskRepository $taskRepo,
        TaskGroupRepository $taskGroupRepo,
        UserTaskRepository $userTaskRepo,
        UserRepository $userRepo,
    ) {
        $this->taskRepo = $taskRepo;
        $this->taskGroupRepo = $taskGroupRepo;
        $this->userTaskRepo = $userTaskRepo;
        $this->userRepo = $userRepo;
    }

    public function store(CreateTaskRequest $request)
    {
        try {
            $task="";
            DB::transaction(function () use ($request, &$task) {
                $inputs = $request->all();
                $task = $this->taskRepo->save($inputs);
                $userTask = [
                    'user_id' => $inputs['user_id'],
                    'task_id' => $task['id'],
                    'role_task' => $inputs['role_id'],
                ];
                $task['class'] = Task::class;
                $this->userTaskRepo->save($userTask);
            });
            return $this->success(['task' => $task]);

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

    public function completedTask($id, CompletedTaskRequest $request) 
    {
        $inputs = $request->only('status');
        $inputs['completed_at'] = now();
        try {
            $this->taskRepo->save($inputs, ['id' => $id]);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getUsers($id) 
    {
        return $this->success([
            'listsUser' => $this->userRepo->getUserTask($id),
        ]);
    }
}
