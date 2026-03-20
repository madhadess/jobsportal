<?php

/* * ******  Gender Start ********** */
Route::get('list-genders', array_merge(['uses' => 'Admin\GenderController@indexGenders'], $all_users))->middleware('check_permission:manage_definitions')->name('list.genders');
Route::get('create-gender', array_merge(['uses' => 'Admin\GenderController@createGender'], $all_users))->middleware('check_permission:manage_definitions')->name('create.gender');
Route::post('store-gender', array_merge(['uses' => 'Admin\GenderController@storeGender'], $all_users))->middleware('check_permission:manage_definitions')->name('store.gender');
Route::get('edit-gender/{id}', array_merge(['uses' => 'Admin\GenderController@editGender'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.gender');
Route::put('update-gender/{id}', array_merge(['uses' => 'Admin\GenderController@updateGender'], $all_users))->middleware('check_permission:manage_definitions')->name('update.gender');
Route::delete('delete-gender', array_merge(['uses' => 'Admin\GenderController@deleteGender'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.gender');
Route::get('fetch-genders', array_merge(['uses' => 'Admin\GenderController@fetchGendersData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.genders');
Route::put('make-active-gender', array_merge(['uses' => 'Admin\GenderController@makeActiveGender'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.gender');
Route::put('make-not-active-gender', array_merge(['uses' => 'Admin\GenderController@makeNotActiveGender'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.gender');
Route::get('sort-genders', array_merge(['uses' => 'Admin\GenderController@sortGenders'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.genders');
Route::get('gender-sort-data', array_merge(['uses' => 'Admin\GenderController@genderSortData'], $all_users))->middleware('check_permission:manage_definitions')->name('gender.sort.data');
Route::put('gender-sort-update', array_merge(['uses' => 'Admin\GenderController@genderSortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('gender.sort.update');
/* * ****** End Gender ********** */