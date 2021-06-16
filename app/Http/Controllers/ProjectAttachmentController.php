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
        if(Gate::allows('can-see-attachments',$id))
        {
            $attachments = Attachment::where('project_id', $id)->get();
            $project = Project::find($id);
            return view('attachments.index',['attachments'=>$attachments, 'project' => $project]);
        }
        else
        {
            abort(403);
        }
    }
    public function show($projectId,$attachmentName){
        return Storage::download('public/attachments/'.$attachmentName);
    }
}
