<?php

/* * ******  Job Start ********** */
Route::get('list-jobs', array_merge(['uses' => 'Admin\JobController@indexJobs'], $all_users))->name('list.jobs')->middleware('check_permission:view_jobs');
Route::get('create-job', array_merge(['uses' => 'Admin\JobController@createJob'], $all_users))->name('create.job')->middleware('check_permission:create_jobs');
Route::post('store-job', array_merge(['uses' => 'Admin\JobController@storeJob'], $all_users))->name('store.job')->middleware('check_permission:create_jobs');
Route::get('edit-job/{id}', array_merge(['uses' => 'Admin\JobController@editJob'], $all_users))->name('edit.job')->middleware('check_permission:edit_jobs');
Route::put('update-job/{id}', array_merge(['uses' => 'Admin\JobController@updateJob'], $all_users))->name('update.job')->middleware('check_permission:edit_jobs');
Route::delete('delete-job', array_merge(['uses' => 'Admin\JobController@deleteJob'], $all_users))->name('delete.job')->middleware('check_permission:delete_jobs');
Route::get('fetch-jobs', array_merge(['uses' => 'Admin\JobController@fetchJobsData'], $all_users))->name('fetch.data.jobs')->middleware('check_permission:view_jobs');
Route::put('make-active-job', array_merge(['uses' => 'Admin\JobController@makeActiveJob'], $all_users))->name('make.active.job')->middleware('check_permission:approve_jobs');
Route::put('make-not-active-job', array_merge(['uses' => 'Admin\JobController@makeNotActiveJob'], $all_users))->name('make.not.active.job')->middleware('check_permission:approve_jobs');
Route::put('make-featured-job', array_merge(['uses' => 'Admin\JobController@makeFeaturedJob'], $all_users))->name('make.featured.job')->middleware('check_permission:feature_jobs');
Route::put('make-not-featured-job', array_merge(['uses' => 'Admin\JobController@makeNotFeaturedJob'], $all_users))->name('make.not.featured.job')->middleware('check_permission:feature_jobs');
Route::get('delete-jobs', array_merge(['uses' => 'Admin\JobController@deleteJobs'], $all_users))->name('delete.jobs')->middleware('check_permission:delete_jobs');

Route::get('list-beta-jobs', array_merge(['uses' => 'Admin\JobBController@indexJobs'], $all_users))->name('list.jobsB')->middleware('check_permission:view_jobs');
Route::get('create-jobB', array_merge(['uses' => 'Admin\JobBController@createJob'], $all_users))->name('create.jobB')->middleware('check_permission:create_jobs');
Route::post('store-jobB', array_merge(['uses' => 'Admin\JobBController@storeJob'], $all_users))->name('store.jobB')->middleware('check_permission:create_jobs');
Route::get('edit-jobB/{id}', array_merge(['uses' => 'Admin\JobBController@editJobB'], $all_users))->name('edit.jobB')->middleware('check_permission:edit_jobs');
Route::put('update-jobB/{id}', array_merge(['uses' => 'Admin\JobBController@updateJobB'], $all_users))->name('update.jobB')->middleware('check_permission:edit_jobs');
Route::delete('delete-jobB', array_merge(['uses' => 'Admin\JobBController@deleteJob'], $all_users))->name('delete.jobB')->middleware('check_permission:delete_jobs');
Route::get('fetch-jobsB', array_merge(['uses' => 'Admin\JobBController@fetchJobsData'], $all_users))->name('fetch.data.jobsB')->middleware('check_permission:view_jobs');
Route::put('make-active-jobB', array_merge(['uses' => 'Admin\JobBController@makeActiveJob'], $all_users))->name('make.active.jobB')->middleware('check_permission:approve_jobs');
Route::put('make-not-active-jobB', array_merge(['uses' => 'Admin\JobBController@makeNotActiveJob'], $all_users))->name('make.not.active.jobB')->middleware('check_permission:approve_jobs');
Route::put('make-featured-jobB', array_merge(['uses' => 'Admin\JobBController@makeFeaturedJob'], $all_users))->name('make.featured.jobB')->middleware('check_permission:feature_jobs');
Route::put('make-not-featured-jobB', array_merge(['uses' => 'Admin\JobBController@makeNotFeaturedJob'], $all_users))->name('make.not.featured.jobB')->middleware('check_permission:feature_jobs');
Route::get('delete-jobsB', array_merge(['uses' => 'Admin\JobBController@deleteJobs'], $all_users))->name('delete.jobsB')->middleware('check_permission:delete_jobs');
Route::get('move-to-active', array_merge(['uses' => 'Admin\JobBController@moveJobs'], $all_users))->name('move-to-active')->middleware('check_permission:approve_jobs');

/* * ****** End Job ********** */