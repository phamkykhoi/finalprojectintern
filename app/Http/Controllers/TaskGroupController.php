<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskGroup\StoreTaskGroupRequest;
use App\Repositories\TaskGroupRepository;
use Illuminate\Http\Request;
use App\Services\TaskGroupService;

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
        return $this->success([
            'taskGroups' => $this->taskGroupRepo->getByActivityId($taskGroupId, ['tasks']),
        ]);
    }

    public function getInfo($taskGroupId)
    {
        try {
            return $this->success([
                'infoTaskGroup' => app(TaskGroupService::class)->getInfoTaskGroup($taskGroupId)
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
