<?php

/* * ******  Testimonial Start ********** */
Route::get('list-testimonials', array_merge(['uses' => 'Admin\TestimonialController@indexTestimonials'], $all_users))->name('list.testimonials')->middleware('check_permission:manage_content,manage_testimonials');
Route::get('create-testimonial', array_merge(['uses' => 'Admin\TestimonialController@createTestimonial'], $all_users))->name('create.testimonial')->middleware('check_permission:manage_content,manage_testimonials');
Route::post('store-testimonial', array_merge(['uses' => 'Admin\TestimonialController@storeTestimonial'], $all_users))->name('store.testimonial')->middleware('check_permission:manage_content,manage_testimonials');
Route::get('edit-testimonial/{id}', array_merge(['uses' => 'Admin\TestimonialController@editTestimonial'], $all_users))->name('edit.testimonial')->middleware('check_permission:manage_content,manage_testimonials');
Route::put('update-testimonial/{id}', array_merge(['uses' => 'Admin\TestimonialController@updateTestimonial'], $all_users))->name('update.testimonial')->middleware('check_permission:manage_content,manage_testimonials');
Route::delete('delete-testimonial', array_merge(['uses' => 'Admin\TestimonialController@deleteTestimonial'], $all_users))->name('delete.testimonial')->middleware('check_permission:manage_content,manage_testimonials');
Route::get('fetch-testimonials', array_merge(['uses' => 'Admin\TestimonialController@fetchTestimonialsData'], $all_users))->name('fetch.data.testimonials')->middleware('check_permission:manage_content,manage_testimonials');
Route::put('make-active-testimonial', array_merge(['uses' => 'Admin\TestimonialController@makeActiveTestimonial'], $all_users))->name('make.active.testimonial')->middleware('check_permission:manage_content,manage_testimonials');
Route::put('make-not-active-testimonial', array_merge(['uses' => 'Admin\TestimonialController@makeNotActiveTestimonial'], $all_users))->name('make.not.active.testimonial')->middleware('check_permission:manage_content,manage_testimonials');
Route::get('sort-testimonials', array_merge(['uses' => 'Admin\TestimonialController@sortTestimonials'], $all_users))->name('sort.testimonials')->middleware('check_permission:manage_content,manage_testimonials');
Route::get('testimonial-sort-data', array_merge(['uses' => 'Admin\TestimonialController@testimonialSortData'], $all_users))->name('testimonial.sort.data')->middleware('check_permission:manage_content,manage_testimonials');
Route::put('testimonial-sort-update', array_merge(['uses' => 'Admin\TestimonialController@testimonialSortUpdate'], $all_users))->name('testimonial.sort.update')->middleware('check_permission:manage_content,manage_testimonials');
/* * ****** End Testimonial ********** */