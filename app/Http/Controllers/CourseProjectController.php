<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Gate;

class CourseProjectController extends Controller
{
    public function index($id)
    {
        if(!Gate::allows('professor-owned',$id)){
            abort(403);
        }
        $projects = Project::where('course_id', $id)->OrderBy('status','desc')->get();
        return view('projects.index',['projects'=>$projects]);
    }
}
