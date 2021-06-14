<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Project;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // use RefreshDatabase;

    //non auth user gets redirected
    public function test_redirecting_non_auth_users()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }
    //auth user can see home
    public function test_an_action_that_requires_authentication()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)
            ->get('/home');
            
        $response->assertStatus(200);
    }
    //user can't see other users courses
    public function test_user_cant_see_other_user_courses()
    {
        $users = User::all();    
        foreach($users as $user){
                for($i=0;$i<count($users);$i++){
                    if($user->id != $users[$i]->id){
                        $response = $this->actingAs($user)->get('/users/'.$users[$i]->id.'/courses');
                        $response->assertStatus(403);
                    }
                }
        }
    }

    //users without right permission cant see the attachments
    public function test_user_cant_see_others_attachments(){
        $users = User::all();
        $projects = Project::all();
        $courses = Course::all();
        foreach($projects as $project){
            foreach($users as $user){
                if($user->id != $project->student_id && $user->role == 2){
                    $response = $this->actingAs($user)->get('/projects/'.$project->id.'/attachments');
                    $response->assertStatus(403);
                }
                if($user->id != $project->student_id && $user->role == 1){
                    $userCourses = Course::whereHas('users', function($query) use ($user){
                        return $query->where('id', $user->id);
                    })->get();
                    foreach($userCourses as $match){
                        if($project->course_id == $match->id){
                            $response = $this->actingAs($user)->get('/projects/'.$project->id.'/attachments');
                            $response->assertStatus(200);
                        }
                        else{
                            $response = $this->actingAs($user)->get('/projects/'.$project->id.'/attachments');
                            $response->assertStatus(403);
                        }
                    }
                }
            }
        }

    }

    public function test_user_cant_post_others_attachments(){
        $users = User::all();
        $projects = Project::all();
        $courses = Course::all();
        foreach($projects as $project){
            foreach($users as $user){
                if($user->id != $project->student_id && $user->role == 2){
                    $response = $this->actingAs($user)->post('/users/'.$user->id.'/projects/'.$project->id.'/attachments');
                    $response->assertStatus(403);
                }
                if($user->id != $project->student_id && $user->role == 1){
                    $userCourses = Course::whereHas('users', function($query) use ($user){
                        return $query->where('id', $user->id);
                    })->get();
                    foreach($userCourses as $match){
                        if($project->course_id == $match->id){
                            $response = $this->actingAs($user)->post('/users/'.$user->id.'/projects/'.$project->id.'/attachments');
                            //here it gets redirected back so asserts 302
                            $response->assertStatus(302);
                        }
                        else{
                            $response = $this->actingAs($user)->post('/users/'.$user->id.'/projects/'.$project->id.'/attachments');
                            $response->assertStatus(403);
                        }
                    }
                }
            }
        }
    }

    //user can't see other users projects, same as courses I could collapse the code easily
    public function test_user_cant_see_or_post_other_user_projects()
    {
        $users = User::all();    
        foreach($users as $user){
                for($i=0;$i<count($users);$i++){
                    if($user->id != $users[$i]->id){
                        $response = $this->actingAs($user)->get('/users/'.$users[$i]->id.'/projects');
                        $response->assertStatus(403);
                        $response = $this->actingAs($user)->post('/users/'.$users[$i]->id.'/projects');
                        $response->assertStatus(403);
                    }
                }
        }
    }

    //user can't try to create other users projects
    public function test_user_cant_create_for_other_users()
    {
        $users = User::all();    
        foreach($users as $user){
                for($i=0;$i<count($users);$i++){
                    if($user->id != $users[$i]->id){
                        $response = $this->actingAs($user)->get('/users/'.$users[$i]->id.'/projects/create');
                        $response->assertStatus(403);
                    }
                }
        }
    }

    //user can't try to make others follow courses
    public function test_user_cant_try_make_others_follow_courses()
    {
        $users = User::all();    
        foreach($users as $user){
                for($i=0;$i<count($users);$i++){
                    if($user->id != $users[$i]->id){
                        $response = $this->actingAs($user)->get('/users/'.$users[$i]->id.'/courses/create');
                        $response->assertStatus(403);
                        $response = $this->actingAs($user)->post('/users/'.$users[$i]->id.'/courses');
                        $response->assertStatus(403);
                    }
                }
        }
    }

    //users 2 and 0 can't use professor's stuff 
    public function test_users_cant_see_prof_routes()
    {
        $user = User::where('role','2')->first();
        $count = count(Course::all());
        for($i=1;$i<=$count;$i++)
        {
            $response = $this->actingAs($user)
            ->get('/courses/'.Course::find($i).'/projects');
            $response->assertStatus(403);
            $response = $this->actingAs($user)->put('/projects/1');
            $response->assertStatus(403);
        }
        $user = User::where('role','0')->first();
        $count = count(Course::all());
        for($i=1;$i<=$count;$i++)
        {
            $response = $this->actingAs($user)
            ->get('/courses/'.Course::find($i).'/projects');
            
            $response->assertStatus(403);
        }  
    }

    //users 2 and 1 can't use admin stuff
    public function test_users_cant_see_admin_routes()
    {
        //admin: see users or courses
        $array = array('/users','/courses');
        $users = User::all();
        foreach($array as $route){
            foreach($users as $user){
                if($user->role != 0){
                    $response = $this->actingAs($user)->get($route);
                    $response->assertStatus(403);
                }
            }
        }
        $courses = Course::all();
        foreach($users as $user){
            foreach($courses as $course){
                //admin: show professors
                $route = '/courses/'.$course->id.'/users';
                if($user->role != 0){
                    $response = $this->actingAs($user)->get($route);
                    $response->assertStatus(403);
                }
                //admin: add professors to course
                $route = '/courses/'.$course->id.'/users/create';
                if($user->role != 0){
                    $response = $this->actingAs($user)->get($route);
                    $response->assertStatus(403);
                }
                //admin: remove a professor from a course
                $route = '/courses/'.$course->id.'/users/'.$user->id;
                if($user->role != 0){
                    $response = $this->actingAs($user)->delete($route);
                    $response->assertStatus(403);
                }
                //this is a further test for everyone not only admin
                $route = '/courses/'.$course->id.'/users/'.$user->id;
                $response = $this->actingAs($user)->get($route);
                $response->assertStatus(404);
            }
            //admin: change role to user
            $route = '/users/'.$user->id.'/edit';
            if($user->role != 0){
                $response = $this->actingAs($user)->get($route);
                $response->assertStatus(403);
            }
            //admin: save change role to user
            $route = '/users/'.$user->id;
            if($user->role != 0){
                $response = $this->actingAs($user)->put($route);
                $response->assertStatus(403);
            }
            //admin: save change role to user
            $route = '/users/'.$user->id;
            if($user->role != 0){
                $response = $this->actingAs($user)->delete($route);
                $response->assertStatus(403);
            }
            //admin: create a course
            $route = '/courses/create';
            if($user->role != 0){
                $response = $this->actingAs($user)->get($route);
                $response->assertStatus(403);
            }
            //admin: save a course
            $route = '/courses';
            if($user->role != 0){
                $response = $this->actingAs($user)->post($route);
                $response->assertStatus(403);
            }
        }
    }
    public function test_user_cant_post_for_others(){
        $users = User::all();    
        foreach($users as $user){
                for($i=0;$i<count($users);$i++){
                    if($user->id != $users[$i]->id){
                        $response = $this->actingAs($user)->post('/users/'.$users[$i]->id.'/courses');
                        $response->assertStatus(403);
                    }
                }
        }
    }
}

