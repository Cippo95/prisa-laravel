<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Course;
use App\Models\Project;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        //students stuff they own
        Gate::define('user-owned', function($user,$id){
            return $user->id==$id;
        });
        //professors can see only courses they teach
        Gate::define('professor-owned', function($user,$course){ 
            $userCourses = Course::whereHas('users', function($query) use ($user){
                return $query->where('id', $user->id);
            })->get();
            return $userCourses->contains('id', $course); 
        });
        //students can only see attachments of their projects
        //professors can only see attachments of projects of their courses
        Gate::define('can-see-attachments', function($user,$id){ 
            if($user->role==2)
            {
                $userProjects = Project::where('student_id', $user->id)->get();
                return $userProjects->contains('id', $id);
            }
            elseif($user->role==1)
            {     
                $project=Project::find($id);      
                $userCourses = Course::whereHas('users', function($query) use ($user){
                    return $query->where('id', $user->id);
                })->get();
                return $userCourses->contains('id', $project->course_id); 
            }
        });

        Gate::define('admin', function($user){
            if($user->role==0){
                return true;
            }
            else{
                return false;
            }
        });
    }
}
