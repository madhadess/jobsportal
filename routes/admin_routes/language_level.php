<?php

/* * ******  LanguageLevel Start ********** */
Route::get('list-language-levels', array_merge(['uses' => 'Admin\LanguageLevelController@indexLanguageLevels'], $all_users))->middleware('check_permission:manage_definitions')->name('list.language.levels');
Route::get('create-language-level', array_merge(['uses' => 'Admin\LanguageLevelController@createLanguageLevel'], $all_users))->middleware('check_permission:manage_definitions')->name('create.language.level');
Route::post('store-language-level', array_merge(['uses' => 'Admin\LanguageLevelController@storeLanguageLevel'], $all_users))->middleware('check_permission:manage_definitions')->name('store.language.level');
Route::get('edit-language-level/{id}', array_merge(['uses' => 'Admin\LanguageLevelController@editLanguageLevel'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.language.level');
Route::put('update-language-level/{id}', array_merge(['uses' => 'Admin\LanguageLevelController@updateLanguageLevel'], $all_users))->middleware('check_permission:manage_definitions')->name('update.language.level');
Route::delete('delete-language-level', array_merge(['uses' => 'Admin\LanguageLevelController@deleteLanguageLevel'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.language.level');
Route::get('fetch-language.levels', array_merge(['uses' => 'Admin\LanguageLevelController@fetchLanguageLevelsData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.language.levels');
Route::put('make-active-language-level', array_merge(['uses' => 'Admin\LanguageLevelController@makeActiveLanguageLevel'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.language.level');
Route::put('make-not-active-language-level', array_merge(['uses' => 'Admin\LanguageLevelController@makeNotActiveLanguageLevel'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.language.level');
Route::get('sort-language-levels', array_merge(['uses' => 'Admin\LanguageLevelController@sortLanguageLevels'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.language.levels');
Route::get('language-level-sort-data', array_merge(['uses' => 'Admin\LanguageLevelController@languageLevelSortData'], $all_users))->middleware('check_permission:manage_definitions')->name('language.level.sort.data');
Route::put('language-level-sort-update', array_merge(['uses' => 'Admin\LanguageLevelController@languageLevelSortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('language.level.sort.update');
/* * ****** End LanguageLevel ********** */