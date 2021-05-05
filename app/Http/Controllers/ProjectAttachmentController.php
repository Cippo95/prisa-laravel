<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Attachment;
use Illuminate\Support\Facades\Gate;


class ProjectAttachmentController extends Controller
{
    public function index($id)
    {
        if(Gate::allows('can-see-attachments',$id))
        {
            $attachments = Attachment::where('project_id', $id)->get();
            $project = Project::where('id', $id)->get();
            return view('attachments.index',['attachments'=>$attachments, 'project' => $project]);
        }
        else
        {
            abort(403);
        }
    }
}
