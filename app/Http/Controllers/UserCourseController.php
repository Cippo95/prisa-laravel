<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Gate;

class UserCourseController extends Controller
{
    public function index($id)
    {
        if(Gate::allows('user-owned',$id))
        {
            $courses = Course::whereHas('users', function($query) use ($id){
                return $query->where('id', $id);
            })->get();
        return view('courses.index',['courses'=>$courses]);
        }
        else
        {
            abort(403);
        }
    }
}
