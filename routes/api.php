<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuildController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ServiceController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('build')->group(function(){
    Route::get('index', [BuildController::class, 'index']);
    Route::post('store', [BuildController::class, 'store']);
    Route::put('update/{id}', [BuildController::class, 'update']);
    Route::get('show/{id}', [BuildController::class, 'show']);
});

Route::prefix('observation')->group(function(){
    Route::get('index', [ObservationController::class, 'index']);
    Route::post('store', [ObservationController::class, 'store']);
    Route::put('update/{id}', [ObservationController::class, 'update']);
    Route::get('show/{id}', [ObservationController::class, 'show']);
});

Route::prefix('room')->group(function(){
    Route::get('index', [RoomController::class, 'index']);
    Route::post('store', [RoomController::class, 'store']);
    Route::put('update/{id}', [RoomController::class, 'update']);
    
    Route::get('show/{id}', [RoomController::class, 'show']);
});

Route::prefix('service')->group(function(){
    Route::get('index', [ServiceController::class, 'index']);
    Route::post('store', [ServiceController::class, 'store']);
    Route::put('update/{id}', [ServiceController::class, 'update']);
    Route::get('show/{id}', [ServiceController::class, 'show']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::group(['middleware' => ["auth:sanctum"]], function (){
    Route::get('userProfile', [AuthController::class, 'userProfile']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::put('changePassword', [AuthController::class, 'changePassword']);
    Route::get('/room/getRoomByUser/{id}', [RoomController::class, 'getRoomByUser']);
    Route::get('/build/getBuildByUser', [BuildController::class, 'getBuildByUser']);
    Route::get('/room/getAllRoomByUser', [RoomController::class, 'getAllRoomByUser']);
    Route::put('/room/changeStatus/{id}', [RoomController::class, 'changeStatus']);
    Route::get('/history/index/{id}', [HistoryController::class, 'index']);
});

