<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('students', 'App\Http\Controllers\ApiController@getAllStudents');
Route::get('students/{student}', 'App\Http\Controllers\ApiController@getStudent');
Route::post('students', 'App\Http\Controllers\ApiController@createStudent');
Route::put('students/{id}', 'App\Http\Controllers\ApiController@updateStudent');
Route::delete('students/{id}','App\Http\Controllers\ApiController@deleteStudent');

Route::get('school', 'App\Http\Controllers\ApiController@getAllSchool');
Route::get('school/{student_id}', 'App\Http\Controllers\ApiController@getSchoolStudent');
Route::post('school', 'App\Http\Controllers\ApiController@createSchool');

Route::post('subject', 'App\Http\Controllers\ApiController@createSubject');
Route::get('subject/{subject}', 'App\Http\Controllers\ApiController@getSubject');
