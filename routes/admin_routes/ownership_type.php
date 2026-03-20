<?php

/* * ******  OwnershipType Start ********** */
Route::get('list-ownership-types', array_merge(['uses' => 'Admin\OwnershipTypeController@indexOwnershipTypes'], $all_users))->middleware('check_permission:manage_definitions')->name('list.ownership.types');
Route::get('create-ownership-type', array_merge(['uses' => 'Admin\OwnershipTypeController@createOwnershipType'], $all_users))->middleware('check_permission:manage_definitions')->name('create.ownership.type');
Route::post('store-ownership-type', array_merge(['uses' => 'Admin\OwnershipTypeController@storeOwnershipType'], $all_users))->middleware('check_permission:manage_definitions')->name('store.ownership.type');
Route::get('edit-ownership-type/{id}', array_merge(['uses' => 'Admin\OwnershipTypeController@editOwnershipType'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.ownership.type');
Route::put('update-ownership-type/{id}', array_merge(['uses' => 'Admin\OwnershipTypeController@updateOwnershipType'], $all_users))->middleware('check_permission:manage_definitions')->name('update.ownership.type');
Route::delete('delete-ownership-type', array_merge(['uses' => 'Admin\OwnershipTypeController@deleteOwnershipType'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.ownership.type');
Route::get('fetch-ownership.types', array_merge(['uses' => 'Admin\OwnershipTypeController@fetchOwnershipTypesData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.ownership.types');
Route::put('make-active-ownership-type', array_merge(['uses' => 'Admin\OwnershipTypeController@makeActiveOwnershipType'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.ownership.type');
Route::put('make-not-active-ownership-type', array_merge(['uses' => 'Admin\OwnershipTypeController@makeNotActiveOwnershipType'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.ownership.type');
Route::get('sort-ownership-types', array_merge(['uses' => 'Admin\OwnershipTypeController@sortOwnershipTypes'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.ownership.types');
Route::get('ownership-type-sort-data', array_merge(['uses' => 'Admin\OwnershipTypeController@ownershipTypeSortData'], $all_users))->middleware('check_permission:manage_definitions')->name('ownership.type.sort.data');
Route::put('ownership-type-sort-update', array_merge(['uses' => 'Admin\OwnershipTypeController@ownershipTypeSortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('ownership.type.sort.update');
/* * ****** End OwnershipType ********** */