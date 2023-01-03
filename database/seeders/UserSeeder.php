<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(['email' => 'root@gmail.com'], [
            'name' => 'Root',
            'email' => 'root@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678@'),
            'role' => User::ROLES['root'],
            'remember_token' => Str::random(10),
        ]);

        User::factory(20)->create();
    }
}
