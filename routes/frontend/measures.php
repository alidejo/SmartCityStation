<?php
/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::group(['middleware' => ['auth', 'password.expires', config('boilerplate.access.middleware.verified')]], function () {

    Route::get('measures/measureindex',[App\Http\Controllers\Frontend\MeasureController::class, 'measureIndex'])->name('measures.measureIndex'); 

    Route::get('variabletype/getvariabletype',[App\Http\Controllers\Backend\Type_variableController::class, 'getVariableType'])->name('variabletype.getvariabletype'); 

});




