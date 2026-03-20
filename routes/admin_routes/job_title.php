<?php

/* * ******  JobTitle Start ********** */
Route::get('list-job-titles', array_merge(['uses' => 'Admin\JobTitleController@indexJobTitles'], $all_users))->middleware('check_permission:manage_definitions')->name('list.job.titles');
Route::get('create-job-title', array_merge(['uses' => 'Admin\JobTitleController@createJobTitle'], $all_users))->middleware('check_permission:manage_definitions')->name('create.job.title');
Route::post('store-job-title', array_merge(['uses' => 'Admin\JobTitleController@storeJobTitle'], $all_users))->middleware('check_permission:manage_definitions')->name('store.job.title');
Route::get('edit-job-title/{id}', array_merge(['uses' => 'Admin\JobTitleController@editJobTitle'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.job.title');
Route::put('update-job-title/{id}', array_merge(['uses' => 'Admin\JobTitleController@updateJobTitle'], $all_users))->middleware('check_permission:manage_definitions')->name('update.job.title');
Route::delete('delete-job-title', array_merge(['uses' => 'Admin\JobTitleController@deleteJobTitle'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.job.title');
Route::get('fetch-job.titles', array_merge(['uses' => 'Admin\JobTitleController@fetchJobTitlesData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.job.titles');
Route::put('make-active-job-title', array_merge(['uses' => 'Admin\JobTitleController@makeActiveJobTitle'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.job.title');
Route::put('make-not-active-job-title', array_merge(['uses' => 'Admin\JobTitleController@makeNotActiveJobTitle'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.job.title');
Route::get('sort-job-titles', array_merge(['uses' => 'Admin\JobTitleController@sortJobTitles'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.job.titles');
Route::get('job-title-sort-data', array_merge(['uses' => 'Admin\JobTitleController@jobTitleSortData'], $all_users))->middleware('check_permission:manage_definitions')->name('job.title.sort.data');
Route::put('job-title-sort-update', array_merge(['uses' => 'Admin\JobTitleController@jobTitleSortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('job.title.sort.update');
/* * ****** End JobTitle ********** */