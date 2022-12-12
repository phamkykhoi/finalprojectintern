<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskGroup;

class TaskGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaskGroup::insert([
            ['id'=>1, 'name'=>'Phân công nhiệm vụ BGĐ', 'descriptions'=>'Phân công nhiệm vụ BGĐ', 'activity_id'=>1, 'type'=>1,],
            ['id'=>2, 'name'=>'Hồ sơ cán bộ', 'descriptions'=>'Hồ sơ cán bộ', 'activity_id'=>2, 'type'=>1,],
            ['id'=>3, 'name'=>'Quy hoạch', 'descriptions'=>'Quy hoạch cán bộ', 'activity_id'=>2, 'type'=>1,],
            ['id'=>4, 'name'=>'Lịch điều xe', 'descriptions'=>'Lịch điều xe', 'activity_id'=>3, 'type'=>1,],
            ['id'=>5, 'name'=>'Lịch Hội trường tầng 4', 'descriptions'=>'Lịch hội trường tầng 4', 'activity_id'=>3, 'type'=>1,],
            ['id'=>6, 'name'=>'Lịch Hội trường tầng 2', 'descriptions'=>'Lịch hội trường tầng 2', 'activity_id'=>3, 'type'=>1,],
            ['id'=>7, 'name'=>'Kế hoạch tuần cơ quan', 'descriptions'=>'KH tuần TTYT', 'activity_id'=>4, 'type'=>1,],
            ['id'=>8, 'name'=>'Kế hoạch tuần phòng KHVN', 'descriptions'=>'KH tuần phòng KHNV', 'activity_id'=>4, 'type'=>1,],
            ['id'=>9, 'name'=>'Ổ dịch Covid 19', 'descriptions'=>'Các ổ dịch covid 19', 'activity_id'=>5, 'type'=>1,],
            ['id'=>10, 'name'=>'Ca bệnh Covid 19', 'descriptions'=>'Các ca bệnh covid 19', 'activity_id'=>5, 'type'=>1,],
        ]); 
    }
}