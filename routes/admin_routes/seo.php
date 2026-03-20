<?php

/* * ******  SEO Field Start ********** */
Route::get('list-seo', array_merge(['uses' => 'Admin\SeoController@indexSeo'], $all_users))->name('list.seo')->middleware('check_permission:manage_seo');
Route::get('create-seo', array_merge(['uses' => 'Admin\SeoController@createSeo'], $all_users))->name('create.seo')->middleware('check_permission:manage_seo');
Route::post('store-seo', array_merge(['uses' => 'Admin\SeoController@storeSeo'], $all_users))->name('store.seo')->middleware('check_permission:manage_seo');
Route::get('edit-seo/{id}/{industry_id?}', array_merge(['uses' => 'Admin\SeoController@editSeo'], $all_users))->name('edit.seo')->middleware('check_permission:manage_seo');
Route::put('update-seo/{id}', array_merge(['uses' => 'Admin\SeoController@updateSeo'], $all_users))->name('update.seo')->middleware('check_permission:manage_seo');
Route::get('fetch-seo', array_merge(['uses' => 'Admin\SeoController@fetchSeoData'], $all_users))->name('fetch.data.seo')->middleware('check_permission:manage_seo');
/* * ****** End SEO Field ********** */
?>