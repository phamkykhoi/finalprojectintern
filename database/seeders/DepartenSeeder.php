<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departen;

class DepartenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departen::insert([
            ['id'=>1, 'name'=>'Ban Giám đốc', 'descriptions'=>'Công việc thuộc BGĐ', 'type'=>1,],
            ['id'=>2, 'name'=>'Phòng HCTCTV', 'descriptions'=>'Công việc thuộc phòng HCTCTV', 'type'=>1,],
            ['id'=>3, 'name'=>'Phòng KHNV', 'descriptions'=>'Công việc thuộc KHNV', 'type'=>1, ],
            ['id'=>4, 'name'=>'Khoa KSBT', 'descriptions'=>'Công việc thuộc khoa KSBT', 'type'=>1,]
        ]);
    }
}
