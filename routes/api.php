<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('type_variables', App\Http\Controllers\API\Backend\Type_variableAPIController::class);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('data_variables', App\Http\Controllers\API\Backend\DataVariableAPIController::class);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('devices', App\Http\Controllers\API\Backend\DeviceAPIController::class);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('villages', App\Http\Controllers\API\Backend\VillageAPIController::class);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('areas', App\Http\Controllers\API\Backend\AreaAPIController::class);
});
