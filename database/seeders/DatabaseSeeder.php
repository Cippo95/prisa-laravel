<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Professor;
use App\Models\Project;
use App\Models\Student;
use App\Models\User;
use App\Models\Attachment;
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
        $user1 = User::create(['name' => $faker->name,'email' => 'student1@unife.it', 'password' => \Hash::make('12345678'), 'role' => 2]);
        $user2 = User::create(['name' => $faker->name,'email' => 'student2@unife.it', 'password' => \Hash::make('12345678'), 'role' => 2]);
        $user3 = User::create(['name' => $faker->name,'email' => 'professor1@unife.it', 'password' => \Hash::make('12345678'), 'role' => 1]);
        $user4 = User::create(['name' => $faker->name,'email' => 'professor2@unife.it', 'password' => \Hash::make('12345678'), 'role' => 1]);
        $user5 = User::create(['name' => 'admin','email' => 'admin@unife.it', 'password' => \Hash::make('12345678'), 'role' => 0]);

        // Let's make a course
        $course1 = Course::create(['name' => 'Fondamenti di intelligenza artificiale']);
        $course2 = Course::create(['name' => 'Ingegneria del software']);

        //Let's make a project for user 1 to course 1
        $project1 = Project::create(['student_id' => 1, 'course_id' => 1, 'status' => 1]);
        $attachment1 = Attachment::create(['project_id' => 1,'user_id' => 1,'message' => 'helloworld']);

        $course1->users()->attach($user1);
        $course1->users()->attach($user2);
        $course2->users()->attach($user1);
        $course2->users()->attach($user2);
        $course1->users()->attach($user3);
        $course2->users()->attach($user4);
    }
}
