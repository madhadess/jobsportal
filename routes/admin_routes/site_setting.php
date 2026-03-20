<?php

/* * ******  SiteSetting Start ********** */
Route::get('edit-site-setting', array_merge(['uses' => 'Admin\SiteSettingController@editsiteSetting'], $all_users))->name('edit.site.setting')->middleware('check_permission:view_settings');
Route::put('update-site-setting', array_merge(['uses' => 'Admin\SiteSettingController@updatesiteSetting'], $all_users))->name('update.site.setting')->middleware('check_permission:manage_settings');
/* * ****** End SiteSetting ********** */
?>