<?php

/* * ******  City Start ********** */
Route::get('list-cities', array_merge(['uses' => 'Admin\CityController@indexCities'], $all_users))->middleware('check_permission:manage_definitions')->name('list.cities');
Route::get('create-city', array_merge(['uses' => 'Admin\CityController@createCity'], $all_users))->middleware('check_permission:manage_definitions')->name('create.city');
Route::post('store-city', array_merge(['uses' => 'Admin\CityController@storeCity'], $all_users))->middleware('check_permission:manage_definitions')->name('store.city');
Route::get('edit-city/{id}', array_merge(['uses' => 'Admin\CityController@editCity'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.city');
Route::put('update-city/{id}', array_merge(['uses' => 'Admin\CityController@updateCity'], $all_users))->middleware('check_permission:manage_definitions')->name('update.city');
Route::delete('delete-city', array_merge(['uses' => 'Admin\CityController@deleteCity'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.city');
Route::get('fetch-cities', array_merge(['uses' => 'Admin\CityController@fetchCitiesData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.cities');
Route::put('make-active-city', array_merge(['uses' => 'Admin\CityController@makeActiveCity'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.city');
Route::put('make-not-active-city', array_merge(['uses' => 'Admin\CityController@makeNotActiveCity'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.city');
Route::get('sort-cities', array_merge(['uses' => 'Admin\CityController@sortCities'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.cities');
Route::get('city-sort-data', array_merge(['uses' => 'Admin\CityController@citySortData'], $all_users))->middleware('check_permission:manage_definitions')->name('city.sort.data');
Route::put('city-sort-update', array_merge(['uses' => 'Admin\CityController@citySortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('city.sort.update');
/* * ****** End City ********** */