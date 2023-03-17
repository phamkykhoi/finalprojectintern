<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TaskGroupService
{
    public function getInfoTaskGroup($taskGroupId)
    {
        $countTasking = 0;

        if (DB::table('tasks')
            ->where('start_date', '<', Carbon::now())
            ->whereNull('end_date')
            ->whereNull('completed_at')
            ->where('task_group_id', $taskGroupId)
            ->exists()) {
                $countTasking = DB::table('tasks')
                    ->where('start_date', '<', Carbon::now())
                    ->whereNull('end_date')
                    ->whereNull('completed_at')
                    ->where('task_group_id', $taskGroupId)
                    ->count();
        } elseif(DB::table('tasks')
            ->where('start_date', '<', Carbon::now())
            ->where('end_date', '>', Carbon::now())
            ->whereNull('completed_at')
            ->where('task_group_id', $taskGroupId)
            ->exists()) {
                $countTasking = DB::table('tasks')
                    ->where('start_date', '<', Carbon::now())
                    ->where('end_date', '>', Carbon::now())
                    ->whereNull('completed_at')
                    ->where('task_group_id', $taskGroupId)
                    ->count();
            }
        
        $countOverDate = DB::table('tasks')
            ->where('end_date', '<', Carbon::now())
            ->orWhere(function($query) {
                $query
                    ->where('completed_at', '>', 'end_date');
            })
            ->count();

        $countTaskFinish = DB::table('tasks')
            ->whereNotNull('completed_at')
            ->where('task_group_id', $taskGroupId)
            ->count();

        $countTotalTask = DB::table('tasks')
            ->where('task_group_id', $taskGroupId)
            ->count();

        return [
            'totalTask' => $countTotalTask,
            'totalTasking' => $countTasking,
            'totalOverDate' => $countOverDate,
            'totalTaskFinish' => $countTaskFinish
        ];
    }
}
