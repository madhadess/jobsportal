<?php

/* * ******  CMS Field Start ********** */
Route::get('list-cms', array_merge(['uses' => 'Admin\CmsController@indexCms'], $all_users))->name('list.cms')->middleware('check_permission:view_pages');
Route::get('create-cms', array_merge(['uses' => 'Admin\CmsController@createCms'], $all_users))->name('create.cms')->middleware('check_permission:manage_pages');
Route::post('store-cms', array_merge(['uses' => 'Admin\CmsController@storeCms'], $all_users))->name('store.cms')->middleware('check_permission:manage_pages');
Route::get('edit-cms/{id}/{industry_id?}', array_merge(['uses' => 'Admin\CmsController@editCms'], $all_users))->name('edit.cms')->middleware('check_permission:manage_pages');
Route::put('update-cms/{id}', array_merge(['uses' => 'Admin\CmsController@updateCms'], $all_users))->name('update.cms')->middleware('check_permission:manage_pages');
Route::delete('delete-cms', array_merge(['uses' => 'Admin\CmsController@deleteCms'], $all_users))->name('delete.cms')->middleware('check_permission:manage_pages');
Route::get('fetch-cms', array_merge(['uses' => 'Admin\CmsController@fetchCmsData'], $all_users))->name('fetch.data.cms')->middleware('check_permission:view_pages');
/* * ****** End CMS Field ********** */
/* * ******  CmsContent Field Start ********** */
Route::get('list-cmsContent', array_merge(['uses' => 'Admin\CmsContentController@indexCmsContent'], $all_users))->name('list.cmsContent')->middleware('check_permission:view_pages');
Route::get('create-cmsContent', array_merge(['uses' => 'Admin\CmsContentController@createCmsContent'], $all_users))->name('create.cmsContent')->middleware('check_permission:manage_pages');
Route::post('store-cmsContent', array_merge(['uses' => 'Admin\CmsContentController@storeCmsContent'], $all_users))->name('store.cmsContent')->middleware('check_permission:manage_pages');
Route::get('edit-cmsContent/{id}/{industry_id?}', array_merge(['uses' => 'Admin\CmsContentController@editCmsContent'], $all_users))->name('edit.cmsContent')->middleware('check_permission:manage_pages');
Route::put('update-cmsContent/{id}', array_merge(['uses' => 'Admin\CmsContentController@updateCmsContent'], $all_users))->name('update.cmsContent')->middleware('check_permission:manage_pages');
Route::delete('delete-cmsContent', array_merge(['uses' => 'Admin\CmsContentController@deleteCmsContent'], $all_users))->name('delete.cmsContent')->middleware('check_permission:manage_pages');
Route::get('fetch-cmsContent', array_merge(['uses' => 'Admin\CmsContentController@fetchCmsContentData'], $all_users))->name('fetch.data.cmsContent')->middleware('check_permission:view_pages');
/* * ****** End CmsContent Field ********** */
?>