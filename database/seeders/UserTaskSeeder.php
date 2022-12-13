<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserTask;

class UserTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserTask::insert([
            ['id'=>1, 'user_id'=>1, 'task_id'=>1, 'role_task'=>1],
            ['id'=>2, 'user_id'=>2, 'task_id'=>1, 'role_task'=>4],
            ['id'=>3, 'user_id'=>3, 'task_id'=>1, 'role_task'=>4],
            ['id'=>4, 'user_id'=>4, 'task_id'=>1, 'role_task'=>4],
            ['id'=>5, 'user_id'=>2, 'task_id'=>2, 'role_task'=>1],
            ['id'=>6, 'user_id'=>1, 'task_id'=>2, 'role_task'=>2],
            ['id'=>7, 'user_id'=>3, 'task_id'=>2, 'role_task'=>4],
            ['id'=>8, 'user_id'=>4, 'task_id'=>2, 'role_task'=>4],
            ['id'=>9, 'user_id'=>5, 'task_id'=>3, 'role_task'=>1],
            ['id'=>10, 'user_id'=>2, 'task_id'=>3, 'role_task'=>2],
            ['id'=>11, 'user_id'=>5, 'task_id'=>4, 'role_task'=>1],
            ['id'=>12, 'user_id'=>2, 'task_id'=>4, 'role_task'=>2],
            ['id'=>13, 'user_id'=>5, 'task_id'=>5, 'role_task'=>1],
            ['id'=>14, 'user_id'=>2, 'task_id'=>5, 'role_task'=>2],
            ['id'=>15, 'user_id'=>5, 'task_id'=>6, 'role_task'=>1],
            ['id'=>16, 'user_id'=>2, 'task_id'=>6, 'role_task'=>2],
            ['id'=>17, 'user_id'=>5, 'task_id'=>7, 'role_task'=>1],
            ['id'=>18, 'user_id'=>2, 'task_id'=>7, 'role_task'=>2],
            ['id'=>19, 'user_id'=>6, 'task_id'=>8, 'role_task'=>1],
            ['id'=>20, 'user_id'=>6, 'task_id'=>9, 'role_task'=>1],
            ['id'=>21, 'user_id'=>3, 'task_id'=>8, 'role_task'=>2],
            ['id'=>22, 'user_id'=>3, 'task_id'=>9, 'role_task'=>2],
            ['id'=>23, 'user_id'=>4, 'task_id'=>10, 'role_task'=>1],
            ['id'=>24, 'user_id'=>4, 'task_id'=>11, 'role_task'=>1],
        ]);
    }
}
