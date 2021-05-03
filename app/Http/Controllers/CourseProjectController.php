<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class CourseProjectController extends Controller
{
    public function index($id)
    {
        $projects = Project::where('course', $id)->get();
        return view('projects.index',['projects'=>$projects]);
    }
}
