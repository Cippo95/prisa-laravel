<?php

use Illuminate\Support\Facades\Route;
// /home
use App\Http\Controllers\HomeController;
// /users/{user}
use App\Http\Controllers\UserProjectController;
// nested resource /users/{user}/courses/{course}
use App\Http\Controllers\UserCourseController;
// nested resource /courses/{course}/projects/{project}
use App\Http\Controllers\CourseProjectController;
// nested resource /projects/{project}/attachments/{attachment}
use App\Http\Controllers\ProjectAttachmentController;
// nested resource /users/{user}/projects/{project}/attachments/{attachment}
use App\Http\Controllers\UserProjectAttachmentController;
// /projects/{project}
use App\Http\Controllers\ProjectController;
// /users/{user}
use App\Http\Controllers\UserController;
// /courses/{course}
use App\Http\Controllers\CourseController;
// /courses/{course}/users/{user}
use App\Http\Controllers\CourseUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

//Route to root, it triggers login and redirects home
Route::get('/', [HomeController::class, 'index'])->middleware('auth');

//Route to home after login
Route::get('/home', [HomeController::class, 'index'])->middleware('auth');

//Route to user's courses
Route::get('/users/{user}/courses', [UserCourseController::class, 'index'])->middleware('auth');

//Route to attachments
Route::get('/projects/{project}/attachments', [ProjectAttachmentController::class, 'index'])->middleware('auth')->name('attachments');

//Route to attachments creation
Route::post('/users/{user}/projects/{project}/attachments', [UserProjectAttachmentController::class, 'store'])->middleware('auth');

//STUDENT ROUTES
//Route to user's projects, user is a student
Route::get('/users/{user}/projects', [UserProjectController::class, 'index'])->middleware('auth')->name('userProjects');

//Route to create a new project
Route::get('/users/{user}/projects/create', [UserProjectController::class, 'create'])->middleware('auth');

//Route to post a new project
Route::post('/users/{user}/projects', [UserProjectController::class, 'store'])->middleware('auth');

//Route to create a row to the pivot table course_user, this is to chose a course that a student follows
Route::get('/users/{user}/courses/create', [UserCourseController::class, 'create'])->middleware('auth');

//Route to store the created row to the pivot table course_user, this is to chose a course that a student follows
Route::post('/users/{user}/courses', [UserCourseController::class, 'store'])->middleware('auth');

//PROFESSOR ONLY ROUTES

//Route to projects related to courses
Route::get('/courses/{course}/projects', [CourseProjectController::class, 'index'])->middleware('auth');

//Route to change project status
Route::put('/projects/{project}',[ProjectController::class, 'update'])->middleware('auth');

//ADMIN ONLY ROUTES

//Routes for admin CRUD of users and courses
Route::resources(['users' => UserController::class,'courses' => CourseController::class]);

//Route to delete a user of a course, again only professors as defined in the controller
Route::delete('/courses/{course}/users/{user}', [CourseUserController::class,'destroy'])->middleware('auth');

//Route to create a row in the pivot table course_user, this is to chose the professor for a course
Route::get('/courses/{course}/users/create', [CourseUserController::class,'create'])->middleware('auth');

//Route to post a row in the pivot table course_user, this is assigning a course to a professor
Route::post('/courses/{course}/users', [CourseUserController::class,'store'])->middleware('auth');

//Route to index that aborts to 404 to not show ignition errors
Route::get('/courses/{course}/users', [CourseUserController::class,'index'])->middleware('auth');

//Route to show that aborts to 404 to not show ignition errors
Route::get('/courses/{course}/users/{user}', [CourseUserController::class,'show'])->middleware('auth');