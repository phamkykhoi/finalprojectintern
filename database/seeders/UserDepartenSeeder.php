<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserDeparten;

class UserDepartenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserDeparten::insert([
            ['id'=>1, 'user_id'=>1, 'departen_id'=>1, 'role_departen'=>1],
            ['id'=>2, 'user_id'=>2, 'departen_id'=>1, 'role_departen'=>4],
            ['id'=>3, 'user_id'=>3, 'departen_id'=>1, 'role_departen'=>4],
            ['id'=>4, 'user_id'=>4, 'departen_id'=>1, 'role_departen'=>4],
            ['id'=>5, 'user_id'=>5, 'departen_id'=>2, 'role_departen'=>1],
            ['id'=>6, 'user_id'=>2, 'departen_id'=>2, 'role_departen'=>2],
            ['id'=>7, 'user_id'=>6, 'departen_id'=>3, 'role_departen'=>1],
            ['id'=>8, 'user_id'=>3, 'departen_id'=>3, 'role_departen'=>2],
            ['id'=>9, 'user_id'=>4, 'departen_id'=>3, 'role_departen'=>3],
            ['id'=>10, 'user_id'=>4, 'departen_id'=>4, 'role_departen'=>1],
        ]);
    }
}
