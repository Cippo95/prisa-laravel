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
        if(!Gate::allows('user-owned',$id)){            
            abort(403);
        }
        $projects = Project::where('student_id', $id)->orderBy('status','desc')->get();
        return view('projects.index',['projects'=>$projects]);
    }

    public function create($id){
        if(!Gate::allows('user-owned',$id)){            
            abort(403);
        }
        $userCourses = Course::whereHas('users', function($query) use ($id){
            return $query->where('id', $id);
        })->get();
        return view('projects.create',['user'=>$id,'userCourses'=>$userCourses]);
    }

    public function store($id){

        if(!Gate::allows('user-owned',$id)){            
            abort(403);
        }
        
        $data=request()->validate([
            'message'=>'required'
        ]);

        $project = new Project();
        $project->student_id = $id;
        $project->course_id = request('course');
        $project->status = 1;
        $project->save();
        $attachment = new Attachment();
        $attachment->project_id = $project->id;
        $attachment->user_id = $id;
        $attachment->message = request('message');
        $attachment->save();
        return redirect()->route('attachments',['project'=>$project->id]);
      }
}
