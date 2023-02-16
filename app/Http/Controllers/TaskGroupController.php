<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskGroup\StoreTaskGroupRequest;
use App\Repositories\TaskGroupRepository;
use Illuminate\Http\Request;

class TaskGroupController extends Controller
{
    protected $taskGroupRepo;

    public function __construct(
        TaskGroupRepository $taskGroupRepo
    ) {
        $this->taskGroupRepo = $taskGroupRepo;
    }

   public function getTaskGroupList($taskGroupId)
    {
        return $this->taskGroupRepo->getByActivityId($taskGroupId, ['tasks']);
    }

    public function store(StoreTaskGroupRequest $request)
    {
        try {
            $this->taskGroupRepo->save($request->all());
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

     public function update($taskGroupId, Request $request)
    {
        try {
            $this->taskGroupRepo->save(['name'=>$request->name],['id' => $taskGroupId]);
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

    public function copyTaskGroup($taskGroupId)
    {
        try {
            $this->taskGroupRepo->copyTaskGroup($taskGroupId);
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

    public function destroy($id){
        try {
            $this->taskGroupRepo->deleteById($id);
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

    public function moveTaskGroup($id,$value){
        try{
            $this->taskGroupRepo->moveTaskGroup($id,$value);
            return response()->json([
                'status' => true,
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
