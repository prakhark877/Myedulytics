<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentDashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::group(['middleware' => 'jwt.auth'], function () {
//     Route::get('/dashboard', [StudentDashboardController::class, 'dashboard']);
// });




Route::post('/refresh', [AuthController::class, 'refresh']);
//Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:api');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

