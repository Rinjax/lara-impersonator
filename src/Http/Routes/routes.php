<?php

Route::prefix('impersonate')
    ->middleware(config('impersonator.route_middleware'))
    ->namespace('\Rinjax\LaraImpersonator\Http\Controllers')
    ->group(function(){
        Route::get('set/{id}', 'ImpersonatorController@impersonate')->name('impersonate.set');
        Route::get('clear', 'ImpersonatorController@clear')->name('impersonate.clear');
});