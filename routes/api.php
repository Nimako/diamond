<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;


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

Route::group(['prefix'=>'user'],function(){
 Route::post('/signup', [AuthController::class, 'signup']);
 Route::post('/login', [AuthController::class, 'login']);

 //Route::post('change-password', 'EmployeeController@ChangePassword');
 //Route::post('reset-password', 'EmployeeController@resetPassword');
});

Route::group(['prefix'=>'card'],function(){
    Route::post('/save-card', [CardController::class, 'AddCard']);
    Route::post('/get-customer-cards', [CardController::class, 'GetCustomerCard']);

});
