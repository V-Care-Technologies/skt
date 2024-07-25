<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\api\CaseController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\MstProductController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('getOtp', [AuthController::class, 'getOtp']);
Route::post('checkOtp', [AuthController::class, 'checkOtp']);
Route::post('login', [AuthController::class, 'login']);
Route::post('checkUser', [AuthController::class, 'checkUser']);

Route::post('editUser', [UserController::class, 'editUser']);
Route::post('updateUser', [UserController::class, 'updateUser']);
Route::get('getNotification', [UserController::class, 'getNotification']);


Route::post('getHomeData', [HomeController::class, 'getHomeData']);
Route::post('getDashboard', [HomeController::class, 'getDashboard']);
Route::post('getCollectCase', [CaseController::class, 'getCollectCase']);
Route::post('getSubmittedCase', [CaseController::class, 'getSubmittedCase']);
Route::post('getSubmitPendingCase', [CaseController::class, 'getSubmitPendingCase']);
Route::post('getVisitCase', [CaseController::class, 'getVisitCase']);
Route::post('addCase', [CaseController::class, 'addCase']);
Route::post('updateCase', [CaseController::class, 'updateCase']);
Route::post('submitCase', [CaseController::class, 'submitCase']);
Route::post('uploadVisitSheet', [CaseController::class, 'uploadVisitSheet']);
Route::post('deleteVisitSheet', [CaseController::class, 'deleteVisitSheet']);
Route::post('uploadPropertyImages', [CaseController::class, 'uploadPropertyImages']);
Route::post('deletePropertyImages', [CaseController::class, 'deletePropertyImages']);
Route::post('addUserTrack', [CaseController::class, 'addUserTrack']);
Route::post('getUserTrack', [CaseController::class, 'getUserTrack']);
Route::post('liveTracking', [CaseController::class, 'liveTracking']);