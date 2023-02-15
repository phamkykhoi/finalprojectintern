<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use App\Http\Requests\Task\CreateTaskRequest;

class TaskController extends Controller
{
    protected $taskRepo;

    public function __construct(TaskRepository $taskRepo)
    {
        $this->taskRepo = $taskRepo;
    }

    public function store(CreateTaskRequest $request)
    {
        try {
            $this->taskRepo->save([
                'name' => $request->name,
                'description' => $request->description,
                'task_group_id' => $request->task_group_id,
            ]);
            
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
}