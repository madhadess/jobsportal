<?php

/* * ******  Industry Start ********** */
Route::get('list-industries', array_merge(['uses' => 'Admin\IndustryController@indexIndustries'], $all_users))->middleware('check_permission:manage_definitions')->name('list.industries');
Route::get('create-industry', array_merge(['uses' => 'Admin\IndustryController@createIndustry'], $all_users))->middleware('check_permission:manage_definitions')->name('create.industry');
Route::post('store-industry', array_merge(['uses' => 'Admin\IndustryController@storeIndustry'], $all_users))->middleware('check_permission:manage_definitions')->name('store.industry');
Route::get('edit-industry/{id}', array_merge(['uses' => 'Admin\IndustryController@editIndustry'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.industry');
Route::put('update-industry/{id}', array_merge(['uses' => 'Admin\IndustryController@updateIndustry'], $all_users))->middleware('check_permission:manage_definitions')->name('update.industry');
Route::delete('delete-industry', array_merge(['uses' => 'Admin\IndustryController@deleteIndustry'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.industry');
Route::get('fetch-industries', array_merge(['uses' => 'Admin\IndustryController@fetchIndustriesData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.industries');
Route::put('make-active-industry', array_merge(['uses' => 'Admin\IndustryController@makeActiveIndustry'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.industry');
Route::put('make-not-active-industry', array_merge(['uses' => 'Admin\IndustryController@makeNotActiveIndustry'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.industry');
Route::get('sort-industries', array_merge(['uses' => 'Admin\IndustryController@sortIndustries'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.industries');
Route::get('industry-sort-data', array_merge(['uses' => 'Admin\IndustryController@industrySortData'], $all_users))->middleware('check_permission:manage_definitions')->name('industry.sort.data');
Route::put('industry-sort-update', array_merge(['uses' => 'Admin\IndustryController@industrySortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('industry.sort.update');
/* * ****** End Industry ********** */