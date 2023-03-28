<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskGroup;
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
        Task::withoutEvents(function () {
            foreach (TaskGroup::all() as $taskGroup) {
                for ($i = 1; $i <= 10; $i++) {
                    Task::create([
                        'name' => fake()->name,
                        'description' => fake()->text(200),
                        'task_group_id' => $taskGroup->id,
                        'start_date' => now(),
                    ]);
                }
            }
        });
        Task::observe(\App\Observers\TaskObserver::class);
    }
}
