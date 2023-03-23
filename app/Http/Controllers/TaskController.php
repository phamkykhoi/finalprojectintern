<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use App\Repositories\TaskGroupRepository;
use App\Repositories\UserTaskRepository;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Requests\Task\CompletedTaskRequest;
use App\Models\Task;
use App\Repositories\ActivityLogRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    protected $taskRepo;

    protected $taskGroupRepo;

    protected $userTaskRepo;

    protected $userRepo;

    protected $activityLogRepo;

    public function __construct(
        TaskRepository $taskRepo,
        TaskGroupRepository $taskGroupRepo,
        UserTaskRepository $userTaskRepo,
        UserRepository $userRepo,
        ActivityLogRepository $activityLogRepo,
    ) {
        $this->taskRepo = $taskRepo;
        $this->taskGroupRepo = $taskGroupRepo;
        $this->userTaskRepo = $userTaskRepo;
        $this->userRepo = $userRepo;
        $this->activityLogRepo = $activityLogRepo;
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
            $request->merge(["completed_at" => $request->status == Task:: STATUS['done'] ? now() : null]);
            $this->taskRepo->save($request->all(), ['id' => $id]);
            return $this->success( ['task' => $this->taskRepo->findById($id)]);
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

    public function getFollowers($id) 
    {
        return $this->success([
            'listFollowers' => $this->userRepo->getMembersTask($id),
        ]);
    }

    public function getPerformers($id) 
    {
        return $this->success([
            'listPerformers' => $this->userRepo->getMembersTask($id),
        ]);
    }
    
    public function cloneTaskById($id)
    {
        try {
            $newTask = $this->taskRepo->cloneTask($id);
            return $this->success(['task' => $newTask]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }

    }

    public function lockTaskById($id)
    {
        try {
            $this->taskRepo->lockTask($id);
            return $this->success();
             } catch (\Exception $e) {

            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function unlockTaskById($id)
    {
        try {
            $this->taskRepo->unlockTask($id);
            return $this->success();
             } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function assignFollower(Request $request)
    {
        $input = $request->only('user_id', 'task_id', 'role_task');
        try {
            return $this->success($this->userTaskRepo->save($input, $input));
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function assignPerformer(Request $request)
    {
        $input = $request->only('user_id', 'task_id', 'role_task');
        try {
            return $this->success($this->userTaskRepo->save($input, $input));
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteMemberInTask($id)
    {
        return $this->success([
            $this->userTaskRepo->deleteById($id),
        ]);
    }

    public function getLogs($id)
    {
        return $this->success([
            'listLogs' => $this->activityLogRepo->getLogs($id),
        ]);
    }
}
