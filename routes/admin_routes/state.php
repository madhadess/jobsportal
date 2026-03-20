<?php

/* * ******  State Start ********** */
Route::get('list-states', array_merge(['uses' => 'Admin\StateController@indexStates'], $all_users))->middleware('check_permission:manage_definitions')->name('list.states');
Route::get('create-state', array_merge(['uses' => 'Admin\StateController@createState'], $all_users))->middleware('check_permission:manage_definitions')->name('create.state');
Route::post('store-state', array_merge(['uses' => 'Admin\StateController@storeState'], $all_users))->middleware('check_permission:manage_definitions')->name('store.state');
Route::get('edit-state/{id}', array_merge(['uses' => 'Admin\StateController@editState'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.state');
Route::put('update-state/{id}', array_merge(['uses' => 'Admin\StateController@updateState'], $all_users))->middleware('check_permission:manage_definitions')->name('update.state');
Route::delete('delete-state', array_merge(['uses' => 'Admin\StateController@deleteState'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.state');
Route::get('fetch-states', array_merge(['uses' => 'Admin\StateController@fetchStatesData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.states');
Route::put('make-active-state', array_merge(['uses' => 'Admin\StateController@makeActiveState'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.state');
Route::put('make-not-active-state', array_merge(['uses' => 'Admin\StateController@makeNotActiveState'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.state');
Route::get('sort-states', array_merge(['uses' => 'Admin\StateController@sortStates'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.states');
Route::get('state-sort-data', array_merge(['uses' => 'Admin\StateController@stateSortData'], $all_users))->middleware('check_permission:manage_definitions')->name('state.sort.data');
Route::put('state-sort-update', array_merge(['uses' => 'Admin\StateController@stateSortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('state.sort.update');
/* * ****** End State ********** */