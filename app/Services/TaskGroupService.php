<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TaskGroupService
{  
     public function getAuthor($taskGroupId)
    {
        return DB::table('task_groups')->where('task_groups.id', $taskGroupId)
        ->value('task_groups.created_by');
    }

    public function getTotalTask($taskGroupId)
    {
        return DB::table('tasks')
        ->where('task_group_id', $taskGroupId)
        ->whereNull('parent_id')
        ->count();
    }

    public function getTaskDoing($taskGroupId)
    {
        $now = Carbon::now();
        return DB::table('tasks')
        ->where(function ($query) use ($now, $taskGroupId) {
            $query->where('task_group_id', $taskGroupId)
                ->where(function ($query) use ($now) {
                    $query->whereNull('start_date')
                    ->orWhereDate('start_date', '<=', Carbon::now()->toDateString());
                })
                ->where(function ($query) use ($now) {
                    $query->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', Carbon::now()->toDateString());
                })
                ->whereNull('completed_at')
                ->whereNull('parent_id');
        })
        ->count();
    }

    public function getTaskNotSchedule($taskGroupId)
    {
        return DB::table('tasks')
        ->where('task_group_id', $taskGroupId)
        ->whereNull('parent_id')
        ->where(function ($query) {
            $query->whereDate('end_date', '<', Carbon::now()->toDateString())
            ->orWhereDate('end_date', '<', DB::raw('DATE(completed_at)'));
        })
        ->count();
    }

    public function getTaskDone($taskGroupId)
    {
        return DB::table('tasks')
        ->whereNotNull('completed_at')
        ->whereNull('parent_id')
        ->where('task_group_id', $taskGroupId)
        ->count();
    }

}
