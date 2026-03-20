<?php

/* * ******  Slider Start ********** */
Route::get('list-sliders', array_merge(['uses' => 'Admin\SliderController@indexSliders'], $all_users))->name('list.sliders')->middleware('check_permission:manage_content,manage_sliders');
Route::get('create-slider', array_merge(['uses' => 'Admin\SliderController@createSlider'], $all_users))->name('create.slider')->middleware('check_permission:manage_content,manage_sliders');
Route::post('store-slider', array_merge(['uses' => 'Admin\SliderController@storeSlider'], $all_users))->name('store.slider')->middleware('check_permission:manage_content,manage_sliders');
Route::get('edit-slider/{id}', array_merge(['uses' => 'Admin\SliderController@editSlider'], $all_users))->name('edit.slider')->middleware('check_permission:manage_content,manage_sliders');
Route::put('update-slider/{id}', array_merge(['uses' => 'Admin\SliderController@updateSlider'], $all_users))->name('update.slider')->middleware('check_permission:manage_content,manage_sliders');
Route::delete('delete-slider', array_merge(['uses' => 'Admin\SliderController@deleteSlider'], $all_users))->name('delete.slider')->middleware('check_permission:manage_content,manage_sliders');
Route::get('fetch-sliders', array_merge(['uses' => 'Admin\SliderController@fetchSlidersData'], $all_users))->name('fetch.data.sliders')->middleware('check_permission:manage_content,manage_sliders');
Route::put('make-active-slider', array_merge(['uses' => 'Admin\SliderController@makeActiveSlider'], $all_users))->name('make.active.slider')->middleware('check_permission:manage_content,manage_sliders');
Route::put('make-not-active-slider', array_merge(['uses' => 'Admin\SliderController@makeNotActiveSlider'], $all_users))->name('make.not.active.slider')->middleware('check_permission:manage_content,manage_sliders');
Route::get('sort-sliders', array_merge(['uses' => 'Admin\SliderController@sortSliders'], $all_users))->name('sort.sliders')->middleware('check_permission:manage_content,manage_sliders');
Route::get('slider-sort-data', array_merge(['uses' => 'Admin\SliderController@sliderSortData'], $all_users))->name('slider.sort.data')->middleware('check_permission:manage_content,manage_sliders');
Route::put('slider-sort-update', array_merge(['uses' => 'Admin\SliderController@sliderSortUpdate'], $all_users))->name('slider.sort.update')->middleware('check_permission:manage_content,manage_sliders');
/* * ****** End Slider ********** */