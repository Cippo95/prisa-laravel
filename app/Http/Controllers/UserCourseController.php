<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Project;
use Illuminate\Support\Facades\Gate;

class UserCourseController extends Controller
{
    public function index($id)
    {
        if(!Gate::allows('user-owned',$id))
        {
            abort(403);
        }
        $courses = Course::whereHas('users', function($query) use ($id){
            return $query->where('id', $id);
        })->get();
        return view('courses.index',['courses'=>$courses]);
    }

    public function create($id){
        if(!Gate::allows('user-owned',$id))
        {
            abort(403);
        }
        $courses=Course::all();
        return view('users.courses.create',['courses'=>$courses, 'user'=>$id]);
    }

    public function store($id){
        if(!Gate::allows('user-owned',$id))
        {
            abort(403);
        }
        $user = User::find($id);
        $user->courses()->attach(request('course'));
        return view('home');
    }

    public function show($id){
        if(Gate::allows('professor-owned',$id)){
            $projects = Project::where('course_id', $id)->OrderBy('status','desc')->get();
            return view('projects.index',['projects'=>$projects]);
        }
        else
        {
            abort(403);
        }
    }
}
