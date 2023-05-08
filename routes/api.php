<?php

use App\Http\Middleware\UserCapability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\UserController;
use App\Http\Controllers\TaskBundleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AssigmentController;
use App\Http\Controllers\ExamController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//Users

Route::post('account/register', [UserController::class, 'register']);
Route::post('account/login', [UserController::class, 'logIn']);
Route::get('account/refresh', [UserController::class, 'refresh']);
Route::post('account/logout', [UserController::class, 'logOut']);

//delete after deply
Route::post('account/createadmin', [UserController::class, 'createSuperUser']);

Route::get('account/users', [UserController::class, 'getAllUsers'])->middleware('role:admin');
Route::post('account/changerole/{id}', [UserController::class, 'changeRole'])->middleware('role:admin');
Route::delete('account/deleteuser/{id}', [UserController::class, 'deleteUser'])->middleware('role:admin');

//tasks

Route::get("taskbundles", [TaskBundleController::class, "getAllTaskBundles"]);



//todo add middlewares
Route::post('upload', [TaskBundleController::class, 'uploadTask']);
Route::get('task/{id}', [TaskController::class, 'getTaskById']);


Route::post('result', [TaskController::class, 'getResultFromTask']);


Route::post('assigments/create', [AssigmentController::class, 'createAssigment']);
Route::get('assigments/active', [AssigmentController::class, 'getAllActiveAssigments']);
Route::get('assigments/pastdue', [AssigmentController::class, 'getPastDueAssigments']);
Route::get('assigments/info/{id}', [AssigmentController::class, 'getAssigmentsInfo']);


Route::get('generatetask/{id}', [ExamController::class, 'generateTaskFromExambundle']);
Route::get('getstudentassigmentpoints/{id}', [ExamController::class, 'getAllPointsFromAssigmentStudent']);
Route::get('teachergradetable/{id}', [ExamController::class, 'getPointsFromExambundle']);

