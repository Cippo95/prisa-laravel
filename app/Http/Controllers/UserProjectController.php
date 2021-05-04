<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Course;
use App\Models\Attachment;
use App\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Gate;

class UserProjectController extends Controller
{
    public function index($id)
    {
        if(Gate::allows('user-projects',$id)){
            $projects = Project::where('student_id', $id)->get();
            return view('projects.index',['projects'=>$projects]);
        }
        else
        {
            abort(403);
        }
    }

    public function create($user){
        $userCourses = Course::whereHas('users', function($query) use ($user){
            return $query->where('id', $user);
        })->get();
        return view('projects.create',['user'=>$user,'userCourses'=>$userCourses]);
    }

    public function store($user){
        $data=request()->validate([
            'message'=>'required'
        ]);

        $project = new Project();
        $project->student_id = $user;
        $project->course_id = request('course');
        $project->save();
        $attachment = new Attachment();
        $attachment->project_id = $project->id;
        $attachment->user_id = $user;
        $attachment->message = request('message');
        $attachment->file = '101';
        $attachment->save();
        return redirect()->route('attachments',['project'=>$project->id]);
      }
}
