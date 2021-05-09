<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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

    public function create($userId){
        if(Gate::allows('user-owned',$userId)){
            $courses=Course::all();
            return view('users.courses.create',['courses'=>$courses, 'user'=>$userId]);
        }
        else
        {
            abort(403);
        }
    }

    public function store($userId){
        $user = User::find($userId);
        $user->courses()->attach(request('course'));
        return view('home');
    }
}
