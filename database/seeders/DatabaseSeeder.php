<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Professor;
use App\Models\Project;
use App\Models\Student;
use App\Models\User;
use Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        // \App\Models\User::factory(10)->create();
        // Let's make two users
        $user1 = User::create(['name' => $faker->name,'email' => 'student@unife.it', 'password' => \Hash::make('12345678'), 'role' => 2]);
        $user2 = User::create(['name' => $faker->name,'email' => 'professor@unife.it', 'password' => \Hash::make('12345678'), 'role' => 1]);
        // Let's make a course
        $course1 = Course::create(['name' => $faker->name]);
        // Let's make a project
        $project1 = Project::create([
            'student' => $user1->id,
            'course' => $course1->id
        ]);
        $course1->users()->attach($user1);
        $course1->users()->attach($user2);
    }
}
