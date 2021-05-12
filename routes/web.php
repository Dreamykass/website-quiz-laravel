<?php

use App\Http\Controllers\ExamStuff;
use App\Http\Controllers\GroupStuff;
use App\Http\Controllers\Login;
use App\Http\Controllers\QuestionStuff;
use App\Http\Controllers\StudentStuff;
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

Route::get('/', function () {
    return view('welcome');
});
//Route::middleware('session.is.student')->group(function () {
//    Route::any('/', "ProfileController@view");
//});
//Route::middleware('session.is.admin')->group(function () {
//    Route::any('/', "gameController@new");
//});

Route::post('/login', [Login::class, 'postLogin']);
Route::get('/logout', [Login::class, 'logout']);

Route::get('/admin', function () {
    return view('admin');
});
Route::get('/student', function () {
    return view('student');
});


Route::get('/err_wrong_login', function () {
    return view('err_wrong_login');
});

Route::get('/student_remove', [StudentStuff::class, 'remove']);
Route::get('/student_new', [StudentStuff::class, 'new_']);
Route::get('/student_rename', [StudentStuff::class, 'rename']);
Route::get('/student_change_password', [StudentStuff::class, 'change_password']);
Route::get('/student_add_to_group', [StudentStuff::class, 'add_to_group']);
Route::get('/student_remove_from_group', [StudentStuff::class, 'remove_from_group']);
Route::get('/student_edit', function () {
    return view('student_edit');
});

Route::get('/group_remove', [GroupStuff::class, 'remove']);
Route::get('/group_new', [GroupStuff::class, 'new_']);

Route::get('/question_remove', [QuestionStuff::class, 'question_remove']);
Route::get('/answer_remove', [QuestionStuff::class, 'answer_remove']);
Route::get('/answer_toggle', [QuestionStuff::class, 'answer_toggle']);
Route::get('/question_new', [QuestionStuff::class, 'question_new']);
Route::get('/answer_new', [QuestionStuff::class, 'answer_new']);
Route::get('/question', function () {
    return view('question');
});

Route::get('/exam_new', [ExamStuff::class, 'exam_new']);
Route::get('/exam_creator', function () {
    return view('exam_creator');
});
Route::get('/exam', function () {
    return view('exam');
});
Route::get('/exam_create', [ExamStuff::class, 'exam_create']);
Route::post('/exam_doing', function () {
    return view('exam_doing');
});
Route::post('/exam_handle_done', [ExamStuff::class, 'exam_handle_done']);
