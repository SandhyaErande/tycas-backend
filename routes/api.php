<?php

use App\Http\Controllers\V1\CustomerController\Authentication;
use App\Http\Controllers\V1\UserController\AuthenticationController;
use App\Http\Controllers\V1\UserController\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\UserController\ClientApiController;
use App\Http\Controllers\V1\RestaurantController\RestaurantApiController;


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
Route::group(['prefix' => 'v1/admin', 'as' => 'v1/admin'], function () {
    Route::post('register',[AuthenticationController::class,'registration']);
    Route::post('login',[AuthenticationController::class,'login']);

    // for System user
    Route::post('createSystemUser',[UserApiController::class,'createSystemUser']);
    Route::get('getSystemUser',[UserApiController::class,'getSystemUser']);
    Route::delete('deleteSystemUser/{id}',[UserApiController::class,'deleteSystemUser']);
});

Route::group(['prefix' => 'v1', 'as' => 'v1'], function () {
    // Send OTP
    Route::post('sendOtp',[Authentication::class,'sendOtp']);
    Route::post('verifyOtp',[Authentication::class,'verifyOtp']);

    // clientRegistration
    Route::post('clientRegister',[ClientApiController::class,'clientRegistration']);
    Route::get('getClient',[ClientApiController::class,'getClient']);
    Route::get('getClientId/{id}',[ClientApiController::class,'getClientById']);
    Route::post('updateClient/{id}',[ClientApiController::class,'updateClient']);
    Route::delete('deleteClient/{id}',[ClientApiController::class,'deleteClient']);


    // for Restaurant user
    Route::post('createRestaurantUser',[RestaurantApiController::class,'createRestaurantUser']);
    Route::get('getRestaurantUser',[RestaurantApiController::class,'getRestaurantUser']);
    Route::delete('deleteRestaurantUser/{id}',[RestaurantApiController::class,'deleteRestaurantUser']);
});