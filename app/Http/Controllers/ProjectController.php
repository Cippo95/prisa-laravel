<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function update($id){
        $project=Project::find($id);
        $project->status=0;
        $project->save();
        return back();
    }
}
