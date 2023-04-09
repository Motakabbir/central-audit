<?php 

use phGov\Logtracker\Http\Controllers\LogtrackerController;

Route::group(['prefix' => 'api/audit-panel-data'], function () {
    
    /*************Default Logs API******************/
    Route::get('/', '\phGov\Auditlog\Http\Controllers\LogtrackerController@logApidata');

    /**************Only for MongoDB**************** */
    Route::get('/log-synchronous', '\phGov\Auditlog\Http\Controllers\LogtrackerController@getUnsynchronousData');
    Route::post('/log-synchronous', '\phGov\Auditlog\Http\Controllers\LogtrackerController@synchronousProcess');
});