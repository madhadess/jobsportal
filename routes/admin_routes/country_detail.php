<?php

/* * ******  CountryDetail Start ********** */
Route::get('list-country-details', array_merge(['uses' => 'Admin\CountryDetailController@indexCountryDetails'], $all_users))->middleware('check_permission:manage_definitions')->name('list.country.details');
Route::get('create-country-detail', array_merge(['uses' => 'Admin\CountryDetailController@createCountryDetail'], $all_users))->middleware('check_permission:manage_definitions')->name('create.country.detail');
Route::post('store-country-detail', array_merge(['uses' => 'Admin\CountryDetailController@storeCountryDetail'], $all_users))->middleware('check_permission:manage_definitions')->name('store.country.detail');
Route::get('edit-country-detail/{id}', array_merge(['uses' => 'Admin\CountryDetailController@editCountryDetail'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.country.detail');
Route::put('update-country-detail/{id}', array_merge(['uses' => 'Admin\CountryDetailController@updateCountryDetail'], $all_users))->middleware('check_permission:manage_definitions')->name('update.country.detail');
Route::delete('delete-country-detail', array_merge(['uses' => 'Admin\CountryDetailController@deleteCountryDetail'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.country.detail');
Route::get('fetch-country.details', array_merge(['uses' => 'Admin\CountryDetailController@fetchCountryDetailsData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.country.details');
Route::put('make-active-country-detail', array_merge(['uses' => 'Admin\CountryDetailController@makeActiveCountryDetail'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.country.detail');
Route::put('make-not-active-country-detail', array_merge(['uses' => 'Admin\CountryDetailController@makeNotActiveCountryDetail'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.country.detail');
Route::get('sort-country-details', array_merge(['uses' => 'Admin\CountryDetailController@sortCountryDetails'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.country.details');
Route::get('country-detail-sort-data', array_merge(['uses' => 'Admin\CountryDetailController@countryDetailSortData'], $all_users))->middleware('check_permission:manage_definitions')->name('country.detail.sort.data');
Route::put('country-detail-sort-update', array_merge(['uses' => 'Admin\CountryDetailController@countryDetailSortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('country.detail.sort.update');
/* * ****** End CountryDetail ********** */
