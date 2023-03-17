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
        return $this->success([
            'taskGroups' => $this->taskGroupRepo->getByActivityId($taskGroupId, ['tasks']),
        ]);
    }

    public function getInfo($taskGroupId)
    {
        try {
            $countTasking = 0;
            $countOverDate = 0;
            $countTaskFinish = 0;
            $tasks = $this->taskGroupRepo->findById($taskGroupId)->tasks()->get();
            foreach($tasks as $task) {
                //count Tasking
                if(($task->start_date && !$task->end_date) && ($task->start_date < getdate()) && !$task->completed_at) {
                    $countTasking+= 1;
                } elseif (($task->start_date && $task->end_date) && ($task->start_date < getdate() && $task->end_date > getdate()) && !$task->completed_at){
                    $countTasking+= 1;
                }
                
                //count Outdate
                if($task->end_date && $task->end_date < getdate()){
                    if($task->completed_at && $task->completed_at > $task->end_date){
                        $countOverDate+= 1;
                    }
                }
                
                //count Task finish
                if($task->completed_at){
                    $countTaskFinish+= 1;
                }
            }

            return $this->success([
                'infoTaskGroup' => [
                    'totalTask' => count($tasks),
                    'totalTasking' => $countTasking,
                    'totalOverDate' => $countOverDate,
                    'totalTaskFinish' => $countTaskFinish
                ]
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
