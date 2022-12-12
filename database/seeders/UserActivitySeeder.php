<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserActivity;

class UserActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserActivity::insert([
            ['id'=>1, 'user_id'=>1, 'activity_id'=>1, 'role_activity'=>1],
            ['id'=>2, 'user_id'=>2, 'activity_id'=>1, 'role_activity'=>4],
            ['id'=>3, 'user_id'=>3, 'activity_id'=>1, 'role_activity'=>4],
            ['id'=>4, 'user_id'=>4, 'activity_id'=>1, 'role_activity'=>4],
            ['id'=>5, 'user_id'=>5, 'activity_id'=>2, 'role_activity'=>1],
            ['id'=>6, 'user_id'=>2, 'activity_id'=>2, 'role_activity'=>2],
            ['id'=>7, 'user_id'=>5, 'activity_id'=>3, 'role_activity'=>1],
            ['id'=>8, 'user_id'=>2, 'activity_id'=>3, 'role_activity'=>2],
            ['id'=>9, 'user_id'=>6, 'activity_id'=>4, 'role_activity'=>1],
            ['id'=>10, 'user_id'=>3, 'activity_id'=>4, 'role_activity'=>2],
            ['id'=>11, 'user_id'=>4, 'activity_id'=>4, 'role_activity'=>3],
            ['id'=>12, 'user_id'=>4, 'activity_id'=>5, 'role_activity'=>1],
        ]);
    }
}
