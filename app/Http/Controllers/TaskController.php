<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use App\Repositories\TaskGroupRepository;
use App\Http\Requests\Task\CreateTaskRequest;

class TaskController extends Controller
{
    protected $taskRepo;

    protected $taskGroupRepo;

    public function __construct(
        TaskRepository $taskRepo,
        TaskGroupRepository $taskGroupRepo
    ) 
    {
        $this->taskRepo = $taskRepo;
        $this->taskGroupRepo = $taskGroupRepo;
    }

    public function store(CreateTaskRequest $request)
    {
        try {
            $this->taskRepo->save($request->only(['name', 'description', 'task_group_id']));
            
            return response()->json([
                'status' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function showJson($id)
    {
        return response()->json([
            'taskGroups' => $this->taskGroupRepo->getByActivityId($id, ['tasks']),
        ]);
    }
}