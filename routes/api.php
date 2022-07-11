<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\RestaurantApiController;
use App\Http\Controllers\V1\SystemApiController;
use App\Http\Controllers\V1\CustomerApiController;

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
Route::group(['prefix' => 'v1', 'as' => 'v1'], function () {
    // for Restaurant
        Route::post('createRestaurantClient',[RestaurantApiController::class,'createClient']);
        // Get Restaurant User
        Route::get('getRestaurantUser',[RestaurantApiController::class,'getUser']);
    
        // for Client
        Route::get('getClient',[RestaurantApiController::class,'getClient']);
        Route::get('getClient/{id}',[RestaurantApiController::class,'getClientById']);
        Route::post('updateClient/{id}',[RestaurantApiController::class,'updateClient']);
        Route::delete('deleteClient/{id}',[RestaurantApiController::class,'deleteClient']);
    
        // softDeleted for Client
        Route::get('restoreClient/{id}',[RestaurantApiController::class,'restoreClient']);
        Route::get('getTrashClient',[RestaurantApiController::class,'getTrash']);
        Route::get('getClientWithTrash',[RestaurantApiController::class,'getClientWithTrash']);
        Route::delete('permanentDelete/{id}',[RestaurantApiController::class,'permanentDelete']);
    
         // for System
        Route::post('createSystemClient',[SystemApiController::class,'createClient']);
        // get system user
        Route::get('getSystemUser',[SystemApiController::class,'getUser']);
    
        // for Customer
        Route::post('createCustomerClient',[CustomerApiController::class,'createClient']);
        // get customer user
        Route::get('getCustomerUser',[CustomerApiController::class,'getUser']);
    
        // Get all Users
        Route::get('getUsers',[RestaurantApiController::class,'getUsers']);
        // Delete User
        Route::delete('deleteUser/{id}',[RestaurantApiController::class,'deleteUser']);
    });
