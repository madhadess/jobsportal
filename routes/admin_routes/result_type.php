<?php

/* * ******  ResultType Start ********** */
Route::get('list-result-types', array_merge(['uses' => 'Admin\ResultTypeController@indexResultTypes'], $all_users))->middleware('check_permission:manage_definitions')->name('list.result.types');
Route::get('create-result-type', array_merge(['uses' => 'Admin\ResultTypeController@createResultType'], $all_users))->middleware('check_permission:manage_definitions')->name('create.result.type');
Route::post('store-result-type', array_merge(['uses' => 'Admin\ResultTypeController@storeResultType'], $all_users))->middleware('check_permission:manage_definitions')->name('store.result.type');
Route::get('edit-result-type/{id}', array_merge(['uses' => 'Admin\ResultTypeController@editResultType'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.result.type');
Route::put('update-result-type/{id}', array_merge(['uses' => 'Admin\ResultTypeController@updateResultType'], $all_users))->middleware('check_permission:manage_definitions')->name('update.result.type');
Route::delete('delete-result-type', array_merge(['uses' => 'Admin\ResultTypeController@deleteResultType'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.result.type');
Route::get('fetch-result.types', array_merge(['uses' => 'Admin\ResultTypeController@fetchResultTypesData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.result.types');
Route::put('make-active-result-type', array_merge(['uses' => 'Admin\ResultTypeController@makeActiveResultType'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.result.type');
Route::put('make-not-active-result-type', array_merge(['uses' => 'Admin\ResultTypeController@makeNotActiveResultType'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.result.type');
Route::get('sort-result-types', array_merge(['uses' => 'Admin\ResultTypeController@sortResultTypes'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.result.types');
Route::get('result-type-sort-data', array_merge(['uses' => 'Admin\ResultTypeController@resultTypeSortData'], $all_users))->middleware('check_permission:manage_definitions')->name('result.type.sort.data');
Route::put('result-type-sort-update', array_merge(['uses' => 'Admin\ResultTypeController@resultTypeSortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('result.type.sort.update');
/* * ****** End ResultType ********** */