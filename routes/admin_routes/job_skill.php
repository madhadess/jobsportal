<?php

/* * ******  JobSkill Start ********** */
Route::get('list-job-skills', array_merge(['uses' => 'Admin\JobSkillController@indexJobSkills'], $all_users))->middleware('check_permission:manage_definitions')->name('list.job.skills');
Route::get('create-job-skill', array_merge(['uses' => 'Admin\JobSkillController@createJobSkill'], $all_users))->middleware('check_permission:manage_definitions')->name('create.job.skill');
Route::post('store-job-skill', array_merge(['uses' => 'Admin\JobSkillController@storeJobSkill'], $all_users))->middleware('check_permission:manage_definitions')->name('store.job.skill');
Route::get('edit-job-skill/{id}', array_merge(['uses' => 'Admin\JobSkillController@editJobSkill'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.job.skill');
Route::put('update-job-skill/{id}', array_merge(['uses' => 'Admin\JobSkillController@updateJobSkill'], $all_users))->middleware('check_permission:manage_definitions')->name('update.job.skill');
Route::delete('delete-job-skill', array_merge(['uses' => 'Admin\JobSkillController@deleteJobSkill'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.job.skill');
Route::get('fetch-job.skills', array_merge(['uses' => 'Admin\JobSkillController@fetchJobSkillsData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.job.skills');
Route::put('make-active-job-skill', array_merge(['uses' => 'Admin\JobSkillController@makeActiveJobSkill'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.job.skill');
Route::put('make-not-active-job-skill', array_merge(['uses' => 'Admin\JobSkillController@makeNotActiveJobSkill'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.job.skill');
Route::get('sort-job-skills', array_merge(['uses' => 'Admin\JobSkillController@sortJobSkills'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.job.skills');
Route::get('job-skill-sort-data', array_merge(['uses' => 'Admin\JobSkillController@jobSkillSortData'], $all_users))->middleware('check_permission:manage_definitions')->name('job.skill.sort.data');
Route::put('job-skill-sort-update', array_merge(['uses' => 'Admin\JobSkillController@jobSkillSortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('job.skill.sort.update');
/* * ****** End JobSkill ********** */