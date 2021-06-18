<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Attachment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;


class ProjectAttachmentController extends Controller
{
    public function index($id)
    {
        if(!Gate::allows('can-see-attachments',$id))
        {
            abort(403);
        }
        $attachments = Attachment::where('project_id', $id)->get();
        $project = Project::find($id);
        return view('attachments.index', compact('attachments'), compact('project'));
    }
    
    public function show($projectId,$attachmentName){
        if(!Gate::allows('can-see-attachments',$projectId))
        {
            abort(403);
        }
        return Storage::download('attachments/'.$attachmentName);
    }
}
