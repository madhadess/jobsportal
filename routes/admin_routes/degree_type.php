<?php

/* * ******  DegreeType Start ********** */
Route::get('list-degree-types', array_merge(['uses' => 'Admin\DegreeTypeController@indexDegreeTypes'], $all_users))->middleware('check_permission:manage_definitions')->name('list.degree.types');
Route::get('create-degree-type', array_merge(['uses' => 'Admin\DegreeTypeController@createDegreeType'], $all_users))->middleware('check_permission:manage_definitions')->name('create.degree.type');
Route::post('store-degree-type', array_merge(['uses' => 'Admin\DegreeTypeController@storeDegreeType'], $all_users))->middleware('check_permission:manage_definitions')->name('store.degree.type');
Route::get('edit-degree-type/{id}', array_merge(['uses' => 'Admin\DegreeTypeController@editDegreeType'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.degree.type');
Route::put('update-degree-type/{id}', array_merge(['uses' => 'Admin\DegreeTypeController@updateDegreeType'], $all_users))->middleware('check_permission:manage_definitions')->name('update.degree.type');
Route::delete('delete-degree-type', array_merge(['uses' => 'Admin\DegreeTypeController@deleteDegreeType'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.degree.type');
Route::get('fetch-degree.types', array_merge(['uses' => 'Admin\DegreeTypeController@fetchDegreeTypesData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.degree.types');
Route::put('make-active-degree-type', array_merge(['uses' => 'Admin\DegreeTypeController@makeActiveDegreeType'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.degree.type');
Route::put('make-not-active-degree-type', array_merge(['uses' => 'Admin\DegreeTypeController@makeNotActiveDegreeType'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.degree.type');
Route::get('sort-degree-types', array_merge(['uses' => 'Admin\DegreeTypeController@sortDegreeTypes'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.degree.types');
Route::get('degree-type-sort-data', array_merge(['uses' => 'Admin\DegreeTypeController@degreeTypeSortData'], $all_users))->middleware('check_permission:manage_definitions')->name('degree.type.sort.data');
Route::put('degree-type-sort-update', array_merge(['uses' => 'Admin\DegreeTypeController@degreeTypeSortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('degree.type.sort.update');
/* * ****** End DegreeType ********** */