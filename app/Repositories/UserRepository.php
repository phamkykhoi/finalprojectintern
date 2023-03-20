<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAll(array $withRelation = null, $role_task = null, $task_id = null)
    {
        // $query = $this->model->leftJoin('user_tasks', 'users.id', '=', 'user_tasks.user_id')
        // ->select('users.*', 'user_tasks.role_task', 'user_tasks.task_id', 'user_tasks.id as user_task_id');
        $query = $this->model->leftJoin('user_tasks', function($join) use ($task_id) {
            $join->on('users.id', '=', 'user_tasks.user_id')
                 ->where('user_tasks.task_id', $task_id)
                 ->orWhereNull('user_tasks.task_id');
        })
        ->select('users.*', 'user_tasks.role_task', 'user_tasks.task_id', 'user_tasks.id as user_task_id')
        ->where('user_tasks.task_id', $task_id)
        ->orWhereNull('user_tasks.task_id');
        
        
        // ->leftJoin('user_tasks', function($join) use ($task_id) {
        //     $join->on('users.id', '=', 'user_tasks.user_id')
        //          ->where(function($query) use ($task_id) {
        //              $query->where('user_tasks.task_id', $task_id)
        //                    ->orWhereNull('user_tasks.task_id');
        //          });
        // })
        // ->orWhereNotExists(function($query) use ($task_id) {
        //     $query->select(DB::raw(1))
        //           ->from('user_tasks')
        //           ->whereRaw('users.id = user_tasks.user_id')
        //           ->where('user_tasks.task_id', $task_id);
        // })
        // ->select('users.*', 'user_tasks.role_task', 'user_tasks.task_id', 'user_tasks.id as user_task_id');
        // if ($withRelation) {
        //     $query->with($withRelation);
        // }
        // if ($task_id) {
        //     $query->where(function($query) use ($role_task) {
        //         $query->where('role_task', $role_task)
        //               ->orWhere('role_task', null);
        //     });
        //     // ->where('task_id', '=', $task_id);
        //     // $query->where(function($query) use ($task_id) {
        //     //     $query->where('task_id', $task_id)->orWhereNull('task_id');
        //     // });
        // }
        if ($role_task) {
            $query->where(function($query) use ($role_task) {
                $query->where('role_task', $role_task)->orWhereNull('role_task');
            });
        }

        return $query->where('users.id', '!=', 1)->get();
    }

    public function getByDepartmentId($departmentId)
    {
        return $this->model->join('user_departments', 'user_departments.user_id', 'users.id')
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'user_departments.role'
            ])
            ->where('user_departments.department_id', $departmentId)
            ->get();
    }

    public function getMembersTask($id = null) {
        return $this->model->with('attachment')->join('user_tasks', 'user_tasks.user_id', 'users.id')
            ->where('user_tasks.task_id', $id)->get();
    }
}
