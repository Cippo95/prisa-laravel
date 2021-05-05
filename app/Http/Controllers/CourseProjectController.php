<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Gate;

class CourseProjectController extends Controller
{
    public function index($id)
    {
        if(Gate::allows('professor-owned',$id)){
            $projects = Project::where('course_id', $id)->get();
            return view('projects.index',['projects'=>$projects]);
        }
        else
        {
            abort(403);
        }
    }
}
