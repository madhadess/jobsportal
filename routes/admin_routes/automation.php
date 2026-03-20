<?php

Route::group(['prefix' => 'automation', 'namespace' => 'Admin', 'middleware' => ['allowed_roles:SUPER_ADMIN,SUB_ADMIN,CALL_CENTER']], function () {
    Route::get('/', 'AutomationController@index')->name('admin.automation.index')->middleware('check_permission:view_automation');
    Route::get('/personnel', 'AutomationController@personnelStats')->name('admin.automation.personnel')->middleware('check_permission:view_automation');
    Route::post('/retry/{id}', 'AutomationController@retryMatching')->name('admin.automation.retry')->middleware('check_permission:manage_automation');
    Route::post('/trigger/{id}', 'AutomationController@triggerMatch')->name('admin.automation.trigger')->middleware('check_permission:manage_automation');
    Route::post('/run-all-pending', 'AutomationController@runAllPending')->name('admin.automation.run-all-pending')->middleware('check_permission:manage_automation');
});
