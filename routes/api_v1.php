<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
                    /**------Admin Login start ------**/
Route::post('login', [App\Http\Controllers\V1\AuthController::class, 'login']);
Route::post('register', [App\Http\Controllers\V1\AuthController::class, 'register']);
                    /**------Admin Login finish ------**/

                    /**------Student Login start ------**/
Route::post('login-student', [App\Http\Controllers\V1\Student\AuthStudentController::class, 'login']);
Route::post('register-student', [App\Http\Controllers\V1\Student\AuthStudentController::class, 'register']);
                    /**------Student Login finish ------**/

                    /**------ Student uchun Termlarni olish ------**/
Route::get('get-term/{term}/{from}', [App\Http\Controllers\V1\Student\TermController::class, "getTerms"]);
Route::get('get-image/{term_id}/', [App\Http\Controllers\V1\Student\TermController::class, "getImage"]);
Route::get('get-video/{term_id}/', [App\Http\Controllers\V1\Student\TermController::class, "getVideo"]);
Route::get('get-object/{term_id}/', [App\Http\Controllers\V1\Student\TermController::class, "getObject"]);


Route::get('search-image-file/{text}', [App\Http\Controllers\V1\ImageFileController::class, "searchImageFile"]);




                    /**------Admin uchun resource start------**/
Route::resources([
    'student' => StudentController::class,
    'category' => CategoryController::class,
    'user' => UserController::class,
    'lesson' => LessonController::class,
    'term' => TermController::class,
]);
                /**------Admin uchun resource finish------**/
