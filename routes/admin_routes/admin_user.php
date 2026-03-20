<?php

/* * ******  Admin User Start ********** */
Route::get('list-admin-users', array_merge(['uses' => 'Admin\AdminController@indexAdminUsers'], $sup_only))->name('list.admin.users')->middleware('check_permission:manage_admins');
Route::get('create-admin-user', array_merge(['uses' => 'Admin\AdminController@createAdminUser'], $sup_only))->name('create.admin.user')->middleware('check_permission:manage_admins');
Route::post('store-admin-user', array_merge(['uses' => 'Admin\AdminController@storeAdminUser'], $sup_only))->name('store.admin.user')->middleware('check_permission:manage_admins');
Route::get('edit-admin-user/{id}', array_merge(['uses' => 'Admin\AdminController@editAdminUser'], $sup_only))->name('edit.admin.user')->middleware('check_permission:manage_admins');
Route::put('update-admin-user/{id}', array_merge(['uses' => 'Admin\AdminController@updateAdminUser'], $sup_only))->name('update.admin.user')->middleware('check_permission:manage_admins');
Route::delete('delete-admin-user', array_merge(['uses' => 'Admin\AdminController@deleteAdminUser'], $sup_only))->name('delete.admin.user')->middleware('check_permission:manage_admins');
Route::get('fetch-admin-users', array_merge(['uses' => 'Admin\AdminController@fetchAdminUsersData'], $sup_only))->name('fetch.data.admin.users')->middleware('check_permission:manage_admins');
/* * ****** End Admin User ********** */
?>