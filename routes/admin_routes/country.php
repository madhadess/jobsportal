<?php

/* * ******  Country Start ********** */
Route::get('list-countries', array_merge(['uses' => 'Admin\CountryController@indexCountries'], $all_users))->middleware('check_permission:manage_definitions')->name('list.countries');
Route::get('create-country', array_merge(['uses' => 'Admin\CountryController@createCountry'], $all_users))->middleware('check_permission:manage_definitions')->name('create.country');
Route::post('store-country', array_merge(['uses' => 'Admin\CountryController@storeCountry'], $all_users))->middleware('check_permission:manage_definitions')->name('store.country');
Route::get('edit-country/{id}', array_merge(['uses' => 'Admin\CountryController@editCountry'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.country');
Route::put('update-country/{id}', array_merge(['uses' => 'Admin\CountryController@updateCountry'], $all_users))->middleware('check_permission:manage_definitions')->name('update.country');
Route::delete('delete-country', array_merge(['uses' => 'Admin\CountryController@deleteCountry'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.country');
Route::get('fetch-countries', array_merge(['uses' => 'Admin\CountryController@fetchCountriesData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.countries');
Route::put('make-active-country', array_merge(['uses' => 'Admin\CountryController@makeActiveCountry'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.country');
Route::put('make-not-active-country', array_merge(['uses' => 'Admin\CountryController@makeNotActiveCountry'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.country');
Route::get('sort-countries', array_merge(['uses' => 'Admin\CountryController@sortCountries'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.countries');
Route::get('country-sort-data', array_merge(['uses' => 'Admin\CountryController@countrySortData'], $all_users))->middleware('check_permission:manage_definitions')->name('country.sort.data');
Route::put('country-sort-update', array_merge(['uses' => 'Admin\CountryController@countrySortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('country.sort.update');
/* * ****** End Country ********** */