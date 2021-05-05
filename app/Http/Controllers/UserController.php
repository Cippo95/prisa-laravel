<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function create(){
        if(Gate::allows('admin')){
            $courses=Course::all();
            return view('users.create',['courses'=>$courses]);
        }
        else
        {
            abort(403);
        }
    }
    public function store($user){
        $data=request()->validate([
            'name'=>'required'
        ]);
        $user->save();
        return view('home');
      }
}
