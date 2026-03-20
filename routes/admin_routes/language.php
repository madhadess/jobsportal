<?php

/* * ******  Language Start ********** */
Route::get('list-languages', array_merge(['uses' => 'Admin\LanguageController@indexLanguages'], $all_users))->middleware('check_permission:manage_definitions')->name('list.languages');
Route::get('create-language', array_merge(['uses' => 'Admin\LanguageController@createLanguage'], $all_users))->middleware('check_permission:manage_definitions')->name('create.language');
Route::post('store-language', array_merge(['uses' => 'Admin\LanguageController@storeLanguage'], $all_users))->middleware('check_permission:manage_definitions')->name('store.language');
Route::get('edit-language/{id}', array_merge(['uses' => 'Admin\LanguageController@editLanguage'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.language');
Route::put('update-language/{id}', array_merge(['uses' => 'Admin\LanguageController@updateLanguage'], $all_users))->middleware('check_permission:manage_definitions')->name('update.language');
Route::delete('delete-language', array_merge(['uses' => 'Admin\LanguageController@deleteLanguage'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.language');
Route::get('fetch-languages', array_merge(['uses' => 'Admin\LanguageController@fetchLanguagesData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.languages');
Route::put('make-active-language', array_merge(['uses' => 'Admin\LanguageController@makeActiveLanguage'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.language');
Route::put('make-default-language', array_merge(['uses' => 'Admin\LanguageController@makeDefaultLanguage'], $all_users))->middleware('check_permission:manage_definitions')->name('make.default.language');
Route::put('make-not-active-language', array_merge(['uses' => 'Admin\LanguageController@makeNotActiveLanguage'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.language');
/* * ****** End Language ********** */