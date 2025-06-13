<?php

namespace Database\Seeders;

use App\Enums\TaskState;
use App\Enums\UserState;
use App\Models\Task;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class FillUsersAndTasksSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        Role::firstOrCreate(['name' => 'programmer', 'guard_name' => 'api']);
        Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'api']);

        $users = collect();
        for ($i = 0; $i < 20; $i++) {
            $custom_roles = $faker->randomElements(['programmer', 'manager'], $faker->numberBetween(1, 2));
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password123'),
                'user_roles' => json_encode($custom_roles),
                'state' => $faker->randomElement(UserState::values()),
            ]);

            $user->assignRole($custom_roles);

            $users->push($user);
        }

        $tasks = collect();
        for ($i = 0; $i < 200; $i++) {
            $task = Task::create([
                'title' => $faker->sentence(3, true),
                'description' => $faker->optional()->paragraph,
                'state' => $faker->randomElement(TaskState::values()),
            ]);

            $randomUsers = $users->random($faker->numberBetween(0, 5));
            $task->users()->syncWithoutDetaching($randomUsers->pluck('id'));

            $tasks->push($task);
        }
    }
}
