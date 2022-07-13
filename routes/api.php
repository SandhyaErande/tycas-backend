<?php

use App\Http\Controllers\V1\CustomerController\Authentication;
use App\Http\Controllers\V1\SystemController\AuthenticationController;
use App\Http\Controllers\V1\SystemController\SystemApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\ClientController\ClientApiController;


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

    // create user
    Route::post('createUser',[SystemApiController::class,'createUser']);
    Route::get('getUser',[SystemApiController::class,'getUser']);
    Route::delete('deleteUser/{id}',[SystemApiController::class,'deleteUser']);
});

Route::group(['prefix' => 'v1', 'as' => 'v1'], function () {
    // Send OTP
    Route::post('sendOtp',[Authentication::class,'sendOtp']);

    // clientRegistration
    Route::post('clientRegister',[ClientApiController::class,'clientRegistration']);
    Route::get('getClient',[ClientApiController::class,'getClient']);
    Route::get('getClientId/{id}',[ClientApiController::class,'getClientById']);
    Route::post('updateClient/{id}',[ClientApiController::class,'updateClient']);
    Route::delete('deleteClient/{id}',[ClientApiController::class,'deleteClient']);


});