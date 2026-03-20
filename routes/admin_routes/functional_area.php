<?php

/* * ******  FunctionalArea Start ********** */
Route::get('list-functional-areas', array_merge(['uses' => 'Admin\FunctionalAreaController@indexFunctionalAreas'], $all_users))->middleware('check_permission:manage_definitions')->name('list.functional.areas');
Route::get('create-functional-area', array_merge(['uses' => 'Admin\FunctionalAreaController@createFunctionalArea'], $all_users))->middleware('check_permission:manage_definitions')->name('create.functional.area');
Route::post('store-functional-area', array_merge(['uses' => 'Admin\FunctionalAreaController@storeFunctionalArea'], $all_users))->middleware('check_permission:manage_definitions')->name('store.functional.area');
Route::get('edit-functional-area/{id}', array_merge(['uses' => 'Admin\FunctionalAreaController@editFunctionalArea'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.functional.area');
Route::put('update-functional-area/{id}', array_merge(['uses' => 'Admin\FunctionalAreaController@updateFunctionalArea'], $all_users))->middleware('check_permission:manage_definitions')->name('update.functional.area');
Route::delete('delete-functional-area', array_merge(['uses' => 'Admin\FunctionalAreaController@deleteFunctionalArea'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.functional.area');
Route::get('fetch-functional.areas', array_merge(['uses' => 'Admin\FunctionalAreaController@fetchFunctionalAreasData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.functional.areas');
Route::put('make-active-functional-area', array_merge(['uses' => 'Admin\FunctionalAreaController@makeActiveFunctionalArea'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.functional.area');
Route::put('make-not-active-functional-area', array_merge(['uses' => 'Admin\FunctionalAreaController@makeNotActiveFunctionalArea'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.functional.area');
Route::get('sort-functional-areas', array_merge(['uses' => 'Admin\FunctionalAreaController@sortFunctionalAreas'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.functional.areas');
Route::get('functional-area-sort-data', array_merge(['uses' => 'Admin\FunctionalAreaController@functionalAreaSortData'], $all_users))->middleware('check_permission:manage_definitions')->name('functional.area.sort.data');
Route::put('functional-area-sort-update', array_merge(['uses' => 'Admin\FunctionalAreaController@functionalAreaSortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('functional.area.sort.update');
/* * ****** End FunctionalArea ********** */