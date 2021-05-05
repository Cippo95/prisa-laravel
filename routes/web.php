<?php

use Illuminate\Support\Facades\Route;

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

//Route to home triggers login
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth');

//Route to home after login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth');

//Route to user's projects
Route::get('/users/{user}/projects/', [App\Http\Controllers\UserProjectController::class, 'index'])->middleware('auth')->name('userProjects');

//Route to create a new project
Route::get('/users/{user}/projects/create', [App\Http\Controllers\UserProjectController::class, 'create'])->middleware('auth');

//Route to post a new project
Route::post('/users/{user}/projects', [App\Http\Controllers\UserProjectController::class, 'store'])->middleware('auth');

//Route to user's courses
Route::get('/users/{user}/courses/', [App\Http\Controllers\UserCourseController::class, 'index'])->middleware('auth');

//Route to projects related to courses
Route::get('/courses/{course}/projects', [App\Http\Controllers\CourseProjectController::class, 'index'])->middleware('auth');

//Route to attachments
Route::get('/projects/{project}/attachments', [App\Http\Controllers\ProjectAttachmentController::class, 'index'])->middleware('auth')->name('attachments');

//Route to attachments creation
Route::post('/users/{user}/projects/{project}/attachments', [App\Http\Controllers\UserProjectAttachmentController::class, 'store'])->middleware('auth');

//Route to admin creating new professors
Route::get('/admin/professor/create',[App\Http\Controllers\UserController::class, 'create'])->middleware('auth');

//Route to admin creating new courses
Route::get('/admin/course/create',[App\Http\Controllers\CourseController::class, 'create'])->middleware('auth');