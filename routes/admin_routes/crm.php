<?php

Route::get('crm', 'Admin\CrmController@index')->name('admin.crm.index')->middleware('check_permission:view_crm');
Route::post('crm/send-notification', 'Admin\CrmController@sendNotification')->name('admin.crm.sendNotification')->middleware('check_permission:manage_crm');
Route::get('crm/get-staff-activities', 'Admin\CrmController@getStaffActivities')->name('admin.crm.getStaffActivities')->middleware('check_permission:view_crm');
Route::get('crm/get-my-notifications', 'Admin\CrmController@getMyNotifications')->name('admin.crm.getMyNotifications');
Route::post('crm/mark-notification-read', 'Admin\CrmController@markNotificationRead')->name('admin.crm.markNotificationRead');
Route::get('crm/get-staff-history/{admin_id}', 'Admin\CrmController@getStaffHistory')->name('admin.crm.getStaffHistory')->middleware('check_permission:view_crm');
Route::post('crm/set-status', 'Admin\CrmController@setStatus')->name('admin.crm.setStatus');
Route::get('crm/profile/{id}', 'Admin\CrmController@show')->name('admin.crm.show')->middleware('check_permission:view_crm');

// CRM Notes
Route::post('crm/notes/store', 'Admin\CrmController@storeNote')->name('admin.crm.notes.store')->middleware('check_permission:manage_crm');
Route::get('crm/notes/get/{admin_id}', 'Admin\CrmController@getNotes')->name('admin.crm.notes.get')->middleware('check_permission:view_crm');
Route::post('crm/notes/toggle/{id}', 'Admin\CrmController@toggleNoteStatus')->name('admin.crm.notes.toggle')->middleware('check_permission:manage_crm');
Route::delete('crm/notes/delete/{id}', 'Admin\CrmController@deleteNote')->name('admin.crm.notes.delete')->middleware('check_permission:manage_crm');

// Personnel Dashboard
Route::get('crm/personnel/dashboard', 'Admin\CrmController@personnelDashboard')->name('admin.crm.personnel');
