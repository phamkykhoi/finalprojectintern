<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use App\Repositories\TaskGroupRepository;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use Illuminate\Support\Facades\Storage;

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
        $inputs = $request->all();
dd($request->all());
        $inputs['fileList'][0]->store('public/avatars');
        try {
            $inputs = $request->all();
            $task = $this->taskRepo->save($inputs);
            $task->attachment()->create([
                'attachable_id' => $task['id'],
                'file_path' => $inputs['fileList']->store('public/avatars'),
                'file_name' => 'sdfsdf',
                'attachable_type' => Task::class,
                'extension' => 'sdfsdf',
                'size' => 1,
                'mime_type' => "fgdfd"
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

    public function show($id)
    {
        return response()->json([
            'taskGroups' => $this->taskGroupRepo->getByActivityId($id, ['tasks']),
        ]);
    }

    public function update($id, UpdateTaskRequest $request)
    {
        try {
            $this->taskRepo->save($request->all(), ['id' => $id]);
            
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}