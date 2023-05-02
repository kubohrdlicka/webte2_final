<?php

use App\Http\Middleware\UserCapability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\UserController;
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

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'logIn']);
//delete after deply
Route::post('createadmin', [UserController::class, 'createSuperUser']);

Route::get('users', [UserController::class, 'getAllUsers'])->middleware('role:admin');
Route::post('changerole', [UserController::class, 'changeRole'])->middleware('role:admin');
Route::post('deleteuser', [UserController::class, 'deleteUser'])->middleware('role:admin');





// Route::get('users', [UserController::class, 'getAllUsers']);
