<?php

use App\Http\Controllers\LocaleController;

/*
 * Global Routes
 *
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LocaleController::class, 'change'])->name('locale.change');

/*
 * Frontend Routes
 */
Route::group(['as' => 'frontend.'], function () {
    includeRouteFiles(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 *
 * These routes can only be accessed by users with type `admin`
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    includeRouteFiles(__DIR__.'/backend/');
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('typeVariables', App\Http\Controllers\Backend\Type_variableController::class, ["as" => 'backend']);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('dataVariables', App\Http\Controllers\Backend\DataVariableController::class, ["as" => 'backend']);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('devices', App\Http\Controllers\Backend\DeviceController::class, ["as" => 'backend']);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('villages', App\Http\Controllers\Backend\VillageController::class, ["as" => 'backend']);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('areas', App\Http\Controllers\Backend\AreaController::class, ["as" => 'backend']);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('locationDevices', App\Http\Controllers\Backend\LocationDeviceController::class, ["as" => 'backend']);
});


Route::group(['prefix' => 'backend'], function () {
    Route::resource('variableDevices', App\Http\Controllers\Backend\VariableDeviceController::class, ["as" => 'backend']);
});


Route::group(['prefix' => 'frontend'], function () {
    Route::resource('measures', App\Http\Controllers\Frontend\MeasureController::class, ["as" => 'frontend']);
});
