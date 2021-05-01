<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseUserController extends Controller
{
    public function index()
    {
        $courses = Course::whereHas('users', function($query){
            return $query->where('id', 1);
        })->get();
        return view('courses.index',['courses'=>$courses]);
    }
}
