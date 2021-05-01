<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('student', '1')->get();
        return view('projects.index',['projects'=>$projects]);
    }
}
