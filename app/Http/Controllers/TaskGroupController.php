<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskGroup\StoreTaskGroupRequest;
use App\Repositories\TaskGroupRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class TaskGroupController extends Controller
{
    protected $taskGroupRepo;

    public function __construct(
        TaskGroupRepository $taskGroupRepo
    ) {
        $this->taskGroupRepo = $taskGroupRepo;
    }

    protected function success($data = null, $statusCode = 200)
    {
        return response()->json([
            'status' => true,
            'result' => $data
        ], $statusCode ?? HttpResponse::HTTP_OK);
    }

    protected function error($message, $statusCode = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $statusCode ?? HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

   public function getTaskGroupList($taskGroupId)
    {
        return $this->taskGroupRepo->getByActivityId($taskGroupId, ['tasks']);
    }

    public function store(StoreTaskGroupRequest $request)
    {
        try {
            $this->taskGroupRepo->save($request->all());
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

     public function update($taskGroupId, Request $request)
    {
        try {
            $this->taskGroupRepo->save(['name'=>$request->name],['id' => $taskGroupId]);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function copy($taskGroupId)
    {
        try {
            $this->taskGroupRepo->copyTaskGroup($taskGroupId);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function destroy($id){
        try {
            $this->taskGroupRepo->deleteById($id);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function move(Request $request){
        try{
            $this->taskGroupRepo->moveTaskGroup($request->get('swapTaskGroupId'),$request->get('moveTaskGroupId'));
            return $this->success();
        } catch(\Exception $e){
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
