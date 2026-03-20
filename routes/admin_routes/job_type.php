<?php

/* * ******  JobType Start ********** */
Route::get('list-job-types', array_merge(['uses' => 'Admin\JobTypeController@indexJobTypes'], $all_users))->middleware('check_permission:manage_definitions')->name('list.job.types');
Route::get('create-job-type', array_merge(['uses' => 'Admin\JobTypeController@createJobType'], $all_users))->middleware('check_permission:manage_definitions')->name('create.job.type');
Route::post('store-job-type', array_merge(['uses' => 'Admin\JobTypeController@storeJobType'], $all_users))->middleware('check_permission:manage_definitions')->name('store.job.type');
Route::get('edit-job-type/{id}', array_merge(['uses' => 'Admin\JobTypeController@editJobType'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.job.type');
Route::put('update-job-type/{id}', array_merge(['uses' => 'Admin\JobTypeController@updateJobType'], $all_users))->middleware('check_permission:manage_definitions')->name('update.job.type');
Route::delete('delete-job-type', array_merge(['uses' => 'Admin\JobTypeController@deleteJobType'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.job.type');
Route::get('fetch-job.types', array_merge(['uses' => 'Admin\JobTypeController@fetchJobTypesData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.job.types');
Route::put('make-active-job-type', array_merge(['uses' => 'Admin\JobTypeController@makeActiveJobType'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.job.type');
Route::put('make-not-active-job-type', array_merge(['uses' => 'Admin\JobTypeController@makeNotActiveJobType'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.job.type');
Route::get('sort-job-types', array_merge(['uses' => 'Admin\JobTypeController@sortJobTypes'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.job.types');
Route::get('job-type-sort-data', array_merge(['uses' => 'Admin\JobTypeController@jobTypeSortData'], $all_users))->middleware('check_permission:manage_definitions')->name('job.type.sort.data');
Route::put('job-type-sort-update', array_merge(['uses' => 'Admin\JobTypeController@jobTypeSortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('job.type.sort.update');
/* * ****** End JobType ********** */