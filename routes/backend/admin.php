<?php

use App\Http\Controllers\Backend\DashboardController;
use Tabuna\Breadcrumbs\Trail;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('admin.dashboard'));
    });

    Route::resource('typeVariables', App\Http\Controllers\Backend\Type_variableController::class);
    Route::resource('dataVariables', App\Http\Controllers\Backend\DataVariableController::class);
    Route::resource('devices', App\Http\Controllers\Backend\DeviceController::class);
    Route::resource('villages', App\Http\Controllers\Backend\VillageController::class);
    Route::resource('areas', App\Http\Controllers\Backend\AreaController::class);
    Route::resource('locationDevices', App\Http\Controllers\Backend\LocationDeviceController::class);
    Route::resource('variableDevices', App\Http\Controllers\Backend\VariableDeviceController::class);
    
    