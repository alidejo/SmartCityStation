<?php
/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::group(['middleware' => ['auth', 'password.expires', config('boilerplate.access.middleware.verified')]], function () {

    Route::get('measures/measureindex',[App\Http\Controllers\Frontend\MeasureController::class, 'measureIndex'])->name('measures.measureIndex'); 

    Route::get('variabletype/getvariabletype',[App\Http\Controllers\Backend\Type_variableController::class, 'getVariableType'])->name('variabletype.getvariabletype'); 

    Route::get('variabledata/getvariabledata',[App\Http\Controllers\Backend\DataVariableController::class, 'getVariableData'])->name('variabledata.getvariabledata');     

    Route::get('measure/showmeasures',[App\Http\Controllers\Frontend\MeasureController::class, 'showMeasures'])->name('measure.showmeasures'); 
    
});




