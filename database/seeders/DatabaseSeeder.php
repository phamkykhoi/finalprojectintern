<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ActivitySeeder::class,
            AttachmentSeeder::class,
            DepartenSeeder::class,
            DiscussionSeeder::class,
            RatingSeeder::class,
            TaskGroupSeeder::class,
            TaskSeeder::class,
            UserActivitySeeder::class,
            UserDepartenSeeder::class,
            UserSeeder::class,
            UserTaskSeeder::class,
    ]);
    }
}
