<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Gate;

class CourseUserController extends Controller
{
    public function index($id)
    {
        if(!Gate::allows('admin')){
            abort(403);
        }
        $users = User::whereHas('courses', function($query) use ($id){
            return $query->where('id', $id);
        })->where('role','1')->get();        
        return view('courses.users.index', ['users'=>$users, 'course'=>$id]);
    }

    public function show($courseId,$userId)
    {
        abort(404);
    }

    public function destroy($courseId,$userId){
        if(!Gate::allows('admin')){
            abort(403);
        }
        $course = Course::find($courseId);
        $course->users()->detach($userId);
        return redirect()->back();
    }

    public function create($courseId){
        if(!Gate::allows('admin')){
            abort(403);
        }
        $users = User::where('role', '1')->get();
        return view('courses.users.create',['users'=>$users, 'course'=>$courseId]);
    }

    public function store($courseId){
        if(!Gate::allows('admin')){
            abort(403);
        }
        $course = Course::find($courseId);
        $course->users()->attach(request('user'));
        return redirect()->action([CourseUserController::class, 'index'], ['course'=>$courseId]);
    }

}
