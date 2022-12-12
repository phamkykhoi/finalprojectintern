<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::insert([
            ['id'=>1, 'name'=>'Giao ban tuần 25', 'descriptions'=>'Chủ trì giao ban tuần', 'task_group_id'=>1, 'type'=>1, 'completed_at'=>'2022-12-10 08:30:04', 'start_date'=>'2022-12-10 08:30:04', 'end_date'=>'2022-12-10 08:30:04', 'is_important'=>'1', 'is_quickly'=>'1','status'=>'1' ],
            ['id'=>2, 'name'=>'Họp SYT', 'descriptions'=>'Họp syt', 'task_group_id'=>1, 'type'=>1, 'completed_at'=>'2022-12-10 08:30:04', 'start_date'=>'2022-12-10 08:30:04', 'end_date'=>'2022-12-10 08:30:04', 'is_important'=>1, 'is_quickly'=>1,'status'=>1 ],
            ['id'=>3, 'name'=>'Báo cáo cán bộ', 'descriptions'=>'Báo cáo CB', 'task_group_id'=>2, 'type'=>1, 'completed_at'=>'2022-12-10 08:30:04', 'start_date'=>'2022-12-10 08:30:04', 'end_date'=>'2022-12-10 08:30:04', 'is_important'=>1, 'is_quickly'=>1,'status'=>1 ],
            ['id'=>4, 'name'=>'Danh sách quy hoạch', 'descriptions'=>'QHCB', 'task_group_id'=>3, 'type'=>1, 'completed_at'=>'2022-12-10 08:30:04', 'start_date'=>'2022-12-10 08:30:04', 'end_date'=>'2022-12-10 08:30:04', 'is_important'=>1, 'is_quickly'=>1,'status'=>1 ],
            ['id'=>5, 'name'=>'Xe họp SYT ngày 15/12', 'descriptions'=>'QHCB', 'task_group_id'=>4, 'type'=>1, 'completed_at'=>'2022-12-10 08:30:04', 'start_date'=>'2022-12-10 08:30:04', 'end_date'=>'2022-12-10 08:30:04', 'is_important'=>1, 'is_quickly'=>1,'status'=>1 ],
            ['id'=>6, 'name'=>'Đón chuyên gia', 'descriptions'=>'ABC', 'task_group_id'=>6, 'type'=>1, 'completed_at'=>'2022-12-10 08:30:04', 'start_date'=>'2022-12-10 08:30:04', 'end_date'=>'2022-12-10 08:30:04', 'is_important'=>1, 'is_quickly'=>1,'status'=>1 ],
            ['id'=>7, 'name'=>'Giao ban TYT', 'descriptions'=>'ABC', 'task_group_id'=>5, 'type'=>1, 'completed_at'=>'2022-12-10 08:30:04', 'start_date'=>'2022-12-10 08:30:04', 'end_date'=>'2022-12-10 08:30:04', 'is_important'=>1, 'is_quickly'=>1,'status'=>1 ],
            ['id'=>8, 'name'=>'Kh Tuần 50', 'descriptions'=>'ABC', 'task_group_id'=>7, 'type'=>1, 'completed_at'=>'2022-12-10 08:30:04', 'start_date'=>'2022-12-10 08:30:04', 'end_date'=>'2022-12-10 08:30:04', 'is_important'=>1, 'is_quickly'=>1,'status'=>1 ],
            ['id'=>9, 'name'=>'Kh Tuần 50', 'descriptions'=>'ABC', 'task_group_id'=>8, 'type'=>1, 'completed_at'=>'2022-12-10 08:30:04', 'start_date'=>'2022-12-10 08:30:04', 'end_date'=>'2022-12-10 08:30:04', 'is_important'=>1, 'is_quickly'=>1,'status'=>1 ],
            ['id'=>10, 'name'=>'Ổ dịch Hạ Lôi', 'descriptions'=>'ABC', 'task_group_id'=>9, 'type'=>1, 'completed_at'=>'2022-12-10 08:30:04', 'start_date'=>'2022-12-10 08:30:04', 'end_date'=>'2022-12-10 08:30:04', 'is_important'=>1, 'is_quickly'=>1,'status'=>1 ],
            ['id'=>11, 'name'=>'Ca bệnh 143', 'descriptions'=>'ABC', 'task_group_id'=>10, 'type'=>1, 'completed_at'=>'2022-12-10 08:30:04', 'start_date'=>'2022-12-10 08:30:04', 'end_date'=>'2022-12-10 08:30:04', 'is_important'=>1, 'is_quickly'=>1,'status'=>1 ],
        ]); 
    }
}
