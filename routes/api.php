<?php

use App\Http\Controllers\V1\CustomerController\Authentication;
use App\Http\Controllers\V1\UserController\AuthenticationController;
use App\Http\Controllers\V1\UserController\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\UserController\ClientApiController;
use App\Http\Controllers\V1\RestaurantController\RestaurantApiController;
use App\Http\Controllers\V1\Category\CategoryApiController;
use App\Http\Controllers\V1\FoodItem\FoodItemApiController;

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

    // softDeleted for User
    Route::get('restoreSystemUser/{id}',[UserApiController::class,'restoreSystemUser']);
    Route::get('getTrashSystemUser',[UserApiController::class,'getTrashSystemUser']);
    Route::get('getSystemUserWithTrash',[UserApiController::class,'getSystemUserWithTrash']);
    Route::delete('deleteSystemUserpermanent/{id}',[UserApiController::class,'deleteSystemUserpermanent']);
});

Route::group(['prefix' => 'v1', 'as' => 'v1'], function () {
    // Send OTP
    Route::post('sendOtp',[Authentication::class,'sendOtp']);
    Route::post('verifyOtp',[Authentication::class,'verifyOtp']);

    // client Registration
    Route::post('clientRegister',[ClientApiController::class,'clientRegistration']);
    Route::get('getClient',[ClientApiController::class,'getClient']);
    Route::get('getClientId/{id}',[ClientApiController::class,'getClientById']);
    Route::post('updateClient/{id}',[ClientApiController::class,'updateClient']);
    Route::delete('deleteClient/{id}',[ClientApiController::class,'deleteClient']);
     // softDeleted for Client
     Route::get('restoreClient/{id}',[ClientApiController::class,'restoreClient']);
     Route::get('getTrashClient',[ClientApiController::class,'getTrashClient']);
     Route::get('getClientWithTrash',[ClientApiController::class,'getClientWithTrash']);
     Route::delete('deleteClientpermanent/{id}',[ClientApiController::class,'deleteClientpermanent']);


    // for Restaurant user
    Route::post('createRestaurantUser',[RestaurantApiController::class,'createRestaurantUser']);
    Route::get('getRestaurantUser',[RestaurantApiController::class,'getRestaurantUser']);
    Route::delete('deleteRestaurantUser/{id}',[RestaurantApiController::class,'deleteRestaurantUser']);

    // for Category
    Route::post('createCategory',[CategoryApiController::class,'createCategory']);
    Route::get('getCategory',[CategoryApiController::class,'getCategory']);
    Route::get('getCategoryId/{id}',[CategoryApiController::class,'getCategoryById']);
    Route::post('updateCategory/{id}',[CategoryApiController::class,'updateCategory']);
    Route::delete('deleteCategory/{id}',[CategoryApiController::class,'deleteCategory']);
     // softDeleted for Category
     Route::get('restoreCategory/{id}',[CategoryApiController::class,'restoreCategory']);
     Route::get('getTrashCategory',[CategoryApiController::class,'getTrashCategory']);
     Route::get('getCategoryWithTrash',[CategoryApiController::class,'getCategoryWithTrash']);
     Route::delete('deleteCategorypermanent/{id}',[CategoryApiController::class,'deleteCategorypermanent']);
 
    //  for FoodItem
    Route::post('createFoodItem',[FoodItemApiController::class,'createFoodItem']);
    Route::get('getFoodItem',[FoodItemApiController::class,'getFoodItem']);
    Route::get('getFoodItemId/{id}',[FoodItemApiController::class,'getFoodItemById']);
    Route::post('updateFoodItem/{id}',[FoodItemApiController::class,'updateFoodItem']);
    Route::delete('deleteFoodItem/{id}',[FoodItemApiController::class,'deleteFoodItem']);
    // softDeleted for FoodItem
    Route::get('restoreFoodItem/{id}',[FoodItemApiController::class,'restoreFoodItem']);
    Route::get('getTrashFoodItem',[FoodItemApiController::class,'getTrashFoodItem']);
    Route::get('getFoodItemWithTrash',[FoodItemApiController::class,'getFoodItemWithTrash']);
    Route::delete('deleteFoodItempermanent/{id}',[FoodItemApiController::class,'deleteFoodItempermanent']);

});