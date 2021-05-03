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
}
