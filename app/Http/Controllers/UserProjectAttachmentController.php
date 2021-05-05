<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Attachment;

class UserProjectAttachmentController extends Controller
{
    public function store($user,$project){
        $data=request()->validate([
            'message'=>'required'
        ]);
        $attachment = new Attachment();
        $attachment->project_id = $project;
        $attachment->user_id = $user;
        $attachment->message = request('message');
        // $attachment->file = request('file');
        $attachment->save();
        return redirect()->back();        
      }
}