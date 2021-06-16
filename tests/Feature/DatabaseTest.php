<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Course;
use App\Models\Attachment;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_project_creation()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['name' => 'Generic Course']);
        $count = count(Project::all());
        $response = $this->actingAs($user)->post('/users/'.$user->id.'/projects',['course'=>$course->id,'message'=>'helloworld']);
        $this->assertCount($count+1,Project::all());
    }

    public function test_course_creation()
    {
        $admin = User::factory()->create(['role' => 0]);
        $count = count(Course::all());
        $response = $this->actingAs($admin)->post('/courses/',['name' => 'Generic course']);
        $this->assertCount($count+1,Course::all());
    }

    public function test_attachment_posting()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['name' => 'Generic course']);
        $project = Project::factory()->create(['student_id' => $user->id, 'course_id' => $course->id]);
        $count = count(Attachment::where('project_id',$project->id)->get());
        $response = $this->actingAs($user)->post('/users/'.$user->id.'/projects/'.$project->id.'/attachments',['message'=>'helloworldagain']);
        $this->assertCount($count+1,Attachment::where('project_id',$project->id)->get());
    }
    //WARNING: REMOVE TIMESTAMP FROM FILE NAME in UserProjectAttachmentController to use this test!

    // public function test_attachment_posting_with_upload()
    // {
    //     $user = User::factory()->create();
    //     $course = Course::factory()->create(['name' => 'Generic course']);
    //     $project = Project::factory()->create(['student_id' => $user->id, 'course_id' => $course->id]);
    //     $count = count(Attachment::where('project_id',$project->id)->get());
    //     Storage::fake('local');    
    //     $file = UploadedFile::fake()->create('document.pdf', 1000);
    //     $response = $this->actingAs($user)->post('/users/'.$user->id.'/projects/'.$project->id.'/attachments',['message'=>'helloworldagain', 'file' => $file]);
    //     $this->assertCount($count+1,Attachment::where('project_id',$project->id)->get());
    //     Storage::disk('local')->assertExists('attachments/document.pdf');
    // }

    public function test_user_adding_course()
    {
        $user = User::factory()->create();
        $count = count(Course::whereHas('users', function($query) use ($user){
            return $query->where('id', $user->id);
        })->get());
        $response = $this->actingAs($user)->post('/users/'.$user->id.'/courses',['course'=>1]);
        $this->assertCount($count+1,Course::whereHas('users', function($query) use ($user){
            return $query->where('id', $user->id);
        })->get());
    }

    public function test_admin_assigning_course_to_prof(){
        //trying a different approach this time, creating all from the beginning
        $admin = User::factory()->create(['role' => 0]);
        $prof = User::factory()->create(['role' => 1]);
        $course = Course::factory()->create(['name' => 'Generic course']);
        //assigning the course to the prof
        $this->actingAs($admin)->post('/courses/'.$course->id.'/users',['user' => $prof->id]);
        $this->assertDatabaseHas('course_user',[
            'user_id' => $prof->id,
            'course_id' => $course->id,
        ]);

    }

    public function test_prof_changing_project_status()
    {
        //trying a different approach this time, creating all from the beginning
        $admin = User::factory()->create(['role' => 0]);
        $prof = User::factory()->create(['role' => 1]);
        $student = User::factory()->create(['role' => 2]);
        $course = Course::factory()->create(['name' => 'Generic course']);
        $project = Project::factory()->create(['course_id' => $course->id, 'student_id' => $student->id]);
        //assigning the course to the prof
        $this->actingAs($admin)->post('/courses/'.$course->id.'/users',['user' => $prof->id]);
        //trying as the prof to change status to the project
        $this->actingAs($prof)->put('/projects/'.$project->id,['status' => 0]);
        $this->assertDatabaseHas('projects',[
            'id'=> $project->id,
            'status' => 0,
        ]);
    }

    public function test_admin_changing_user_role(){
        $admin = User::factory()->create(['role' => 0]);
        $user = User::factory()->create(['role' => 2]);
        //make the user an admin
        $this->actingAs($admin)->put('/users/'.$user->id,['role' => 0]);
        $this->assertDatabaseHas('users',[
            'id'=> $user->id,
            'role' => 0,
        ]);
        //make the user a professor
        $this->actingAs($admin)->put('/users/'.$user->id,['role' => 1]);
        $this->assertDatabaseHas('users',[
            'id'=> $user->id,
            'role' => 1,
        ]);
        //make the user a student
        $this->actingAs($admin)->put('/users/'.$user->id,['role' => 2]);
        $this->assertDatabaseHas('users',[
            'id'=> $user->id,
            'role' => 2,
        ]);
    }
    public function test_admin_can_delete_user(){
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => 0]);
        $count = count(User::all());
        $this->actingAs($admin)->delete('/users/'.$user->id);
        $this->assertCount($count-1,User::all());
    }

    public function test_user_can_follow_course(){
        $user = User::factory()->create();
        $course = Course::factory()->create(['name' => 'Generic course']);
        $this->actingAs($user)->post('/users/'.$user->id.'/courses',['course' => $course->id]);
        $this->assertDatabaseHas('course_user',[
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    public function admin_can_delete_course(){
        $admin = User::factory()->create(['role' => 0]);
        $course = Course::factory()->create(['name' => 'Generic course']);
        $count = count(Course::all());
        $this->actingAs($admin)->delete('/courses/'.$course->id);
        $this->assertCount($count-1,Course::all());
    }

}
