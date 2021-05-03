<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Course;
use App\Models\Attachment;

class UserProjectController extends Controller
{
    public function index($id)
    {
        $projects = Project::where('student', $id)->get();
        return view('projects.index',['projects'=>$projects]);
    }

    public function create($user){
        $userCourses = Course::whereHas('users', function($query) use ($user){
            return $query->where('id', $user);
        })->get();
        return view('projects.create',['user'=>$user,'userCourses'=>$userCourses]);
    }

    public function store($user){
        $project = new Project();
        $project->student = $user;
        $project->course = request('course');
        $project->save();
        $attachment = new Attachment();
        $attachment->project_id = $project->id;
        $attachment->user_id = $user;
        $attachment->message = request('message');
        $attachment->file = '101';
        $attachment->save();
        return redirect('/projects/{project}/attachments',['project'=>$project->id]);
      }
}
