<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Attachment;
use Illuminate\Support\Facades\Gate;

class UserProjectAttachmentController extends Controller
{
    public function store($user,$project,Request $request){

        if(!Gate::allows('can-see-attachments',$project)){
             abort(403);
        }
        // $data=request()->validate([
        //     'message'=>'required',
        //     'file' => 'nullable|max:1999'
        // ]);
        $this->validate($request,[
            'message'=>'required',
            'file' => 'nullable|max:1999'
        ]);
        //Handle file upload
        if($request->hasFile('file')){
            //Get filename with extension
            $filenameWithExt = $request -> file('file')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('file')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('file')->storeAs('public/attachments', $fileNameToStore);
            //Create attachment
            $attachment = new Attachment();
            $attachment->project_id = $project;
            $attachment->user_id = $user;
            $attachment->message = request('message');
            $attachment->file_name = $fileNameToStore;
        }
        else{
            //Create attachment
            $attachment = new Attachment();
            $attachment->project_id = $project;
            $attachment->user_id = $user;
            $attachment->message = request('message');
        }
        $attachment->save();
        return redirect()->back();        
      }
}