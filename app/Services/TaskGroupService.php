<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TaskGroupService
{
    public function getInfoTaskGroup($taskGroupId)
    {
        $countTasking = DB::table('tasks')
            ->where(function($query) use ($taskGroupId){
                $query->where('start_date', '<=', Carbon::now())
                ->whereNotNull('start_date')
                ->whereNull('end_date')
                ->whereNull('completed_at')
                ->whereNull('parent_id')
                ->where('task_group_id', $taskGroupId);
            })
            ->orWhere(function($query) use ($taskGroupId){
                $query->where('end_date', '>=', Carbon::now())
                ->whereNotNull('start_date')
                ->whereNotNull('end_date')
                ->whereNull('completed_at')
                ->whereNull('parent_id')
                ->where('task_group_id', $taskGroupId);
            })
            ->count();
        
        $countOverDate = DB::table('tasks')
            ->where(function($query) use ($taskGroupId){
                $query->where('end_date', '<', Carbon::now())
                    ->where('task_group_id', $taskGroupId)
                    ->whereNull('parent_id')
                    ->whereNull('completed_at');
            })
            ->orWhere(function($query) use ($taskGroupId){
                $query->where('end_date', '<', 'completed_at')
                    ->where('task_group_id', $taskGroupId)
                    ->whereNull('parent_id')
                    ->whereNotNull('completed_at');
            })
            ->count();

        $countTaskFinish = DB::table('tasks')
            ->whereNotNull('completed_at')
            ->whereNull('parent_id')
            ->where('task_group_id', $taskGroupId)
            ->count();

        $countTotalTask = DB::table('tasks')
            ->where('task_group_id', $taskGroupId)
            ->whereNull('parent_id')
            ->count();

        return [
            'totalTask' => $countTotalTask,
            'totalTasking' => $countTasking,
            'totalOverDate' => $countOverDate,
            'totalTaskFinish' => $countTaskFinish
        ];
    }
}
