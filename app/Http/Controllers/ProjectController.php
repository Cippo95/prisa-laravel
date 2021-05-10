<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    public function update($id){
        if(!Gate::allows('project-professor',$id)){
            abort(403);
        }
        $project=Project::find($id);
        $project->status=0;
        $project->save();
        return back();
    }
}
