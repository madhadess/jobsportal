<?php

/* * ******  User Start ********** */
Route::get('list-users', array_merge(['uses' => 'Admin\UserController@indexUsers'], $all_users))->name('list.users')->middleware('check_permission:view_users');
Route::get('list-applicants', array_merge(['uses' => 'Admin\UserController@appliedUsers'], $all_users))->name('list.applicants')->middleware('check_permission:view_users');
Route::get('fetch-applicants', array_merge(['uses' => 'Admin\UserController@fetchApplicantsData'], $all_users))->name('fetch.data.applicants')->middleware('check_permission:view_users');
Route::get('reject-candidate/{id}', array_merge(['uses' => 'Admin\UserController@rejectCandidate'], $all_users))->name('reject.candidate')->middleware('check_permission:edit_users');
Route::get('delete-users', array_merge(['uses' => 'Admin\UserController@deleteUsers'], $all_users))->name('delete.users')->middleware('check_permission:delete_users');
Route::get('view-public-profile/{id}', array_merge(['uses' => 'AjaxController@viewpublicprofile'], $all_users))->name('admin.view.public.profile')->middleware('check_permission:view_users');

Route::get('create-user', array_merge(['uses' => 'Admin\UserController@createUser'], $all_users))->name('create.user')->middleware('check_permission:create_users');
Route::post('store-user', array_merge(['uses' => 'Admin\UserController@storeUser'], $all_users))->name('store.user')->middleware('check_permission:create_users');
Route::get('edit-user/{id}', array_merge(['uses' => 'Admin\UserController@editUser'], $all_users))->name('edit.user')->middleware('check_permission:edit_users');
Route::put('update-user/{id}', array_merge(['uses' => 'Admin\UserController@updateUser'], $all_users))->name('update.user')->middleware('check_permission:edit_users');
Route::delete('delete-user', array_merge(['uses' => 'Admin\UserController@deleteUser'], $all_users))->name('delete.user')->middleware('check_permission:delete_users');
Route::get('fetch-users', array_merge(['uses' => 'Admin\UserController@fetchUsersData'], $all_users))->name('fetch.data.users')->middleware('check_permission:view_users');
Route::put('make-active-user', array_merge(['uses' => 'Admin\UserController@makeActiveUser'], $all_users))->name('make.active.user')->middleware('check_permission:edit_users');
Route::put('make-not-active-user', array_merge(['uses' => 'Admin\UserController@makeNotActiveUser'], $all_users))->name('make.not.active.user')->middleware('check_permission:edit_users');
Route::put('make-verified-user', array_merge(['uses' => 'Admin\UserController@makeVerifiedUser'], $all_users))->name('make.verified.user')->middleware('check_permission:edit_users');
Route::put('make-not-verified-user', array_merge(['uses' => 'Admin\UserController@makeNotVerifiedUser'], $all_users))->name('make.not.verified.user')->middleware('check_permission:edit_users');

/* * *********************************** */
Route::post('update-profile-summary/{id}', array_merge(['uses' => 'Admin\UserController@updateProfileSummary'], $all_users))->name('update.profile.summary')->middleware('check_permission:edit_users');
/* * *********************************** */
Route::post('show-profile-cvs/{id}', array_merge(['uses' => 'Admin\UserController@showProfileCvs'], $all_users))->name('show.profile.cvs')->middleware('check_permission:view_users');
Route::post('upload-cv-temp-image', array_merge(['uses' => 'Admin\UserController@uploadCvTempImage'], $all_users))->name('upload.cv.temp.image')->middleware('check_permission:edit_users');
Route::post('get-profile-cv-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileCvForm'], $all_users))->name('get.profile.cv.form')->middleware('check_permission:edit_users');
Route::post('store-profile-cv/{id}', array_merge(['uses' => 'Admin\UserController@storeProfileCv'], $all_users))->name('store.profile.cv')->middleware('check_permission:edit_users');
Route::post('get-profile-cv-edit-form/{user_id}', array_merge(['uses' => 'Admin\UserController@getProfileCvEditForm'], $all_users))->name('get.profile.cv.edit.form')->middleware('check_permission:edit_users');
Route::post('update-profile-cv/{id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateProfileCv'], $all_users))->name('update.profile.cv')->middleware('check_permission:edit_users');
Route::delete('delete-profile-cv', array_merge(['uses' => 'Admin\UserController@deleteProfileCv'], $all_users))->name('delete.profile.cv')->middleware('check_permission:delete_users');
/* * *********************************** */
Route::post('show-profile-projects/{id}', array_merge(['uses' => 'Admin\UserController@showProfileProjects'], $all_users))->name('show.profile.projects')->middleware('check_permission:view_users');
Route::post('upload-project-temp-image', array_merge(['uses' => 'Admin\UserController@uploadProjectTempImage'], $all_users))->name('upload.project.temp.image')->middleware('check_permission:edit_users');
Route::post('get-profile-project-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileProjectForm'], $all_users))->name('get.profile.project.form')->middleware('check_permission:edit_users');
Route::post('store-profile-project/{id}', array_merge(['uses' => 'Admin\UserController@storeProfileProject'], $all_users))->name('store.profile.project')->middleware('check_permission:edit_users');
Route::post('get-profile-project-edit-form/{user_id}', array_merge(['uses' => 'Admin\UserController@getProfileProjectEditForm'], $all_users))->name('get.profile.project.edit.form')->middleware('check_permission:edit_users');
Route::put('update-profile-project/{id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateProfileProject'], $all_users))->name('update.profile.project')->middleware('check_permission:edit_users');
Route::delete('delete-profile-project', array_merge(['uses' => 'Admin\UserController@deleteProfileProject'], $all_users))->name('delete.profile.project')->middleware('check_permission:delete_users');
/* * *********************************** */
Route::post('show-profile-experience/{id}', array_merge(['uses' => 'Admin\UserController@showProfileExperience'], $all_users))->name('show.profile.experience')->middleware('check_permission:view_users');
Route::post('get-profile-experience-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileExperienceForm'], $all_users))->name('get.profile.experience.form')->middleware('check_permission:edit_users');
Route::post('store-profile-experience/{id}', array_merge(['uses' => 'Admin\UserController@storeProfileExperience'], $all_users))->name('store.profile.experience')->middleware('check_permission:edit_users');
Route::post('get-profile-experience-edit-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileExperienceEditForm'], $all_users))->name('get.profile.experience.edit.form')->middleware('check_permission:edit_users');
Route::put('update-profile-experience/{profile_experience_id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateProfileExperience'], $all_users))->name('update.profile.experience')->middleware('check_permission:edit_users');
Route::delete('delete-profile-experience', array_merge(['uses' => 'Admin\UserController@deleteProfileExperience'], $all_users))->name('delete.profile.experience')->middleware('check_permission:delete_users');
/* * *********************************** */
Route::post('show-profile-education/{id}', array_merge(['uses' => 'Admin\UserController@showProfileEducation'], $all_users))->name('show.profile.education')->middleware('check_permission:view_users');
Route::post('get-profile-education-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileEducationForm'], $all_users))->name('get.profile.education.form')->middleware('check_permission:edit_users');
Route::post('store-profile-education/{id}', array_merge(['uses' => 'Admin\UserController@storeProfileEducation'], $all_users))->name('store.profile.education')->middleware('check_permission:edit_users');
Route::post('get-profile-education-edit-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileEducationEditForm'], $all_users))->name('get.profile.education.edit.form')->middleware('check_permission:edit_users');
Route::put('update-profile-education/{education_id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateProfileEducation'], $all_users))->name('update.profile.education')->middleware('check_permission:edit_users');
Route::delete('delete-profile-education', array_merge(['uses' => 'Admin\UserController@deleteProfileEducation'], $all_users))->name('delete.profile.education')->middleware('check_permission:delete_users');
/* * *********************************** */
Route::post('show-profile-skills/{id}', array_merge(['uses' => 'Admin\UserController@showProfileSkills'], $all_users))->name('show.profile.skills')->middleware('check_permission:view_users');
Route::post('get-profile-skill-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileSkillForm'], $all_users))->name('get.profile.skill.form')->middleware('check_permission:edit_users');
Route::post('store-profile-skill/{id}', array_merge(['uses' => 'Admin\UserController@storeProfileSkill'], $all_users))->name('store.profile.skill')->middleware('check_permission:edit_users');
Route::post('get-profile-skill-edit-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileSkillEditForm'], $all_users))->name('get.profile.skill.edit.form')->middleware('check_permission:edit_users');
Route::put('update-profile-skill/{skill_id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateProfileSkill'], $all_users))->name('update.profile.skill')->middleware('check_permission:edit_users');
Route::delete('delete-profile-skill', array_merge(['uses' => 'Admin\UserController@deleteProfileSkill'], $all_users))->name('delete.profile.skill')->middleware('check_permission:delete_users');
/* * *********************************** */
Route::post('show-profile-languages/{id}', array_merge(['uses' => 'Admin\UserController@showProfileLanguages'], $all_users))->name('show.profile.languages')->middleware('check_permission:view_users');
Route::post('get-profile-language-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileLanguageForm'], $all_users))->name('get.profile.language.form')->middleware('check_permission:edit_users');
Route::post('store-profile-language/{id}', array_merge(['uses' => 'Admin\UserController@storeProfileLanguage'], $all_users))->name('store.profile.language')->middleware('check_permission:edit_users');
Route::post('get-profile-language-edit-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileLanguageEditForm'], $all_users))->name('get.profile.language.edit.form')->middleware('check_permission:edit_users');
Route::put('update-profile-language/{language_id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateProfileLanguage'], $all_users))->name('update.profile.language')->middleware('check_permission:edit_users');
Route::delete('delete-profile-language', array_merge(['uses' => 'Admin\UserController@deleteProfileLanguage'], $all_users))->name('delete.profile.language')->middleware('check_permission:delete_users');
Route::post('assign-package', array_merge(['uses' => 'Admin\UserController@assignPackage'], $all_users))->name('assign.package')->middleware('check_permission:edit_users');
/* * ****** End User ********** */
?>