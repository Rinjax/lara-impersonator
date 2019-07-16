<?php

Route::prefix('impersonate')
    ->middleware(['web', 'https', 'impersonate'])
    ->namespace('\Rinjax\LaraImpersonator\Http\Controllers')
    ->group(function(){
        Route::get('set-id/{id}', 'ImpersonatorController@impersonate')->name('impersonate.set');
        Route::get('clear', 'ImpersonatorController@clear')->name('impersonate.clear');
});