<?php

Route::group(['middleware' => ['admin_activity']], function () {
    Route::get('security', 'Admin\SecurityController@index')->name('admin.security.index')->middleware('check_permission:manage_security');
    Route::post('security/update', 'Admin\SecurityController@update')->name('admin.security.update')->middleware('check_permission:manage_security');
});
