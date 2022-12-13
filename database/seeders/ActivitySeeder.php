<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Activity::insert([
            ['id'=>1, 'name'=>'Phân công BGĐ', 'descriptions'=>'Phân công công việc BGĐ', 'departen_id'=>1, 'type'=>1,],
            ['id'=>2, 'name'=>'Tổ chức cán bộ', 'descriptions'=>'Công việcTCCB', 'departen_id'=>2, 'type'=>1,],
            ['id'=>3, 'name'=>'Hành chính cơ quan', 'descriptions'=>'Công việc Hành chính', 'departen_id'=>2, 'type'=>1,],
            ['id'=>4, 'name'=>'Kế hoạch đơn vị', 'descriptions'=>'Công việc KHNV', 'departen_id'=>3, 'type'=>1,],
            ['id'=>5, 'name'=>'Covid 19', 'descriptions'=>'Công việc covid', 'departen_id'=>4, 'type'=>1,],
        ]);
    }
}
