<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attachment;

class ProjectAttachmentController extends Controller
{
    public function index($id)
    {
        $attachments = Attachment::where('project_id', $id)->get();
        return view('attachments.index',['attachments'=>$attachments,'project_id' => $id]);
    }

    public function store($user,$project){
        $data=request()->validate([
            'message'=>'required'
        ]);
        $attachment = new Attachment();
        $attachment->project_id = $project;
        $attachment->user_id = $user;
        $attachment->message = request('message');
        $attachment->file = '101';
        $attachment->save();
        return redirect()->back();        
      }
}
