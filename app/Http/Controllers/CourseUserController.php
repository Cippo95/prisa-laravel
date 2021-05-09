<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Course;


class CourseUserController extends Controller
{
    public function index($id)
    {
        $users = User::whereHas('courses', function($query) use ($id){
            return $query->where('id', $id);
        })->where('role','1')->get();        
        return view('courses.users.index', ['users'=>$users, 'course'=>$id]);
    }

    public function destroy($courseId,$userId){
        $course = Course::find($courseId);
        $course->users()->detach($userId);
        return back();
    }

    public function create($courseId){
        $users = User::where('role', '1')->get();
        return view('courses.users.create',['users'=>$users, 'course'=>$courseId]);
    }

    public function store($courseId){
        $course = Course::find($courseId);
        $course->users()->attach(request('user'));
        return redirect()->action([CourseUserController::class, 'index'], ['course'=>$courseId]);
    }

}
