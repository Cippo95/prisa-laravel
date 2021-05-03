<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function store($user,$project,$message){
        $attachment = new Attachment();
        $attachment->project_id = $project;
        $attachment->user_id = $user;
        $attachment->message = $message;
        $attachment->save();
        return view('attachments');        
      }
}
