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

        $this->validate($request,[
            'message'=>'required',
            'file' => 'nullable|max:1999'
        ]);

        //Create attachment
        $attachment = new Attachment();
        $attachment->project_id = $project;
        $attachment->user_id = $user;
        $attachment->message = request('message');

        //Check if file upload
        if($request->hasFile('file')){
            //Get filename with extension
            $filenameWithExt = $request -> file('file')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            // $extension = $request->file('file')->getClientOriginalExtension();
            $extension = $request->file('file')->extension();
            //Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload
            $path = $request->file('file')->storeAs('attachments',$fileNameToStore);

            // FOR TESTING UPLOAD USE THIS AND COMMENT LINE BEFORE: I can't check for a file modified as in the test
            // $path = $request->file('file')->storeAs('attachments',$filenameWithExt);

            // Save file name for retrieving
            $attachment->file_name = $fileNameToStore;
        }

        //save to db
        $attachment->save();
        return redirect()->back();        
      }
}