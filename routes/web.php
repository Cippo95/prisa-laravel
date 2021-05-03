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

// Route::get('/', function () {
//     return view('welcome');
//   });

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Auth::routes();
//Route to home after login
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth');
//Route to home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
//Route to user's projects
Route::get('/users/{user}/projects/', [App\Http\Controllers\UserProjectController::class, 'index'])->name('userProjects');
//Route to create a new project
Route::get('/users/{user}/projects/create', [App\Http\Controllers\UserProjectController::class, 'create']);
//Route to post a new project
Route::post('/users/{user}/projects', [App\Http\Controllers\UserProjectController::class, 'store']);
//Route to user's courses
Route::get('/users/{user}/courses/', [App\Http\Controllers\UserCourseController::class, 'index']);
//Route to projects related to courses
Route::get('/courses/{course}/projects', [App\Http\Controllers\CourseProjectController::class, 'index']);
//Route to attachments
Route::get('/projects/{project}/attachments', [App\Http\Controllers\ProjectAttachmentController::class, 'index'])->name('attachments');
//Route to attachments creation
Route::post('/attachments', [App\Http\Controllers\ProjectAttachmentController::class, 'store'])->name('attachmentCreate');
