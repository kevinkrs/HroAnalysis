<?php

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

//Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/import', 'ImportController@getIndex');
Route::post('/import', 'ImportController@postIndex');

//For Course
Route::get('/course', 'CourseController@index');
Route::get('/course/{course_code}', 'CourseController@show');
Route::get('/course/destroy/{course_code}', 'CourseController@destroy');
//
Route::get('/import/destroy/{course_code}', 'ImportController@destroy');
Route::get('/import/revert', 'ImportController@revert');

//
//For feedback
Route::get('/feedback/destroy/{id}/{redirect}', 'FeedbackController@destroy');
//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');


Route::get('/', 'CourseController@index');