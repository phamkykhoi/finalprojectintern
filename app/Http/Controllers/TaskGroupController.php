<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskGroup\StoreTaskGroupRequest;
use App\Repositories\TaskGroupRepository;
use Illuminate\Http\Request;
use App\Services\TaskGroupService;

class TaskGroupController extends Controller
{
    protected $taskGroupRepo;

    protected $taskGroupService;

    public function __construct(
        TaskGroupRepository $taskGroupRepo,
        TaskGroupService $taskGroupService
    ) {
        $this->taskGroupRepo = $taskGroupRepo;
        $this->taskGroupService = $taskGroupService;
    }

   public function getTaskGroupList($taskGroupId)
    {
        return $this->success([
            'taskGroups' => $this->taskGroupRepo->getByActivityId($taskGroupId, ['tasks']),
        ]);
    }

    public function getInfo($taskGroupId)
    {

        try {
            return $this->success([
                'author' => $this->taskGroupService->getAuthor($taskGroupId),
                'total_task' => $this->taskGroupService->getTotalTask($taskGroupId),
                'total_task_doing' => $this->taskGroupService->getTaskDoing($taskGroupId),
                'total_task_not_schedule' => $this->taskGroupService->getTaskNotSchedule($taskGroupId),
                'total_task_done' => $this->taskGroupService->getTaskDone($taskGroupId),
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function store(StoreTaskGroupRequest $request)
    {
        try {
            $inputs = $request->all();
            $inputs['created_by'] = auth()->user()->name;
            $this->taskGroupRepo->save($inputs);
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
                if(!$this->taskGroupRepo->checkRelation($id))
                {
                    $this->taskGroupRepo->deleteById($id);
                    return $this->success();
                }
                return $this->error("You cannot delete a taskgroup containing tasks!!");
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
