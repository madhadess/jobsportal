<?php

/* * ******  FAQ Field Start ********** */
Route::get('list-faqs', array_merge(['uses' => 'Admin\FaqController@indexFaqs'], $all_users))->name('list.faqs')->middleware('check_permission:manage_content,manage_faqs');
Route::get('create-faq', array_merge(['uses' => 'Admin\FaqController@createFaq'], $all_users))->name('create.faq')->middleware('check_permission:manage_content,manage_faqs');
Route::post('store-faq', array_merge(['uses' => 'Admin\FaqController@storeFaq'], $all_users))->name('store.faq')->middleware('check_permission:manage_content,manage_faqs');
Route::get('edit-faq/{id}/{industry_id?}', array_merge(['uses' => 'Admin\FaqController@editFaq'], $all_users))->name('edit.faq')->middleware('check_permission:manage_content,manage_faqs');
Route::put('update-faq/{id}', array_merge(['uses' => 'Admin\FaqController@updateFaq'], $all_users))->name('update.faq')->middleware('check_permission:manage_content,manage_faqs');
Route::delete('delete-faq', array_merge(['uses' => 'Admin\FaqController@deleteFaq'], $all_users))->name('delete.faq')->middleware('check_permission:manage_content,manage_faqs');
Route::get('fetch-faqs', array_merge(['uses' => 'Admin\FaqController@fetchFaqsData'], $all_users))->name('fetch.data.faqs')->middleware('check_permission:manage_content,manage_faqs');
Route::get('sort-faq', array_merge(['uses' => 'Admin\FaqController@sortFaqs'], $all_users))->name('sort.faqs')->middleware('check_permission:manage_content,manage_faqs');
Route::get('faq-sort-data', array_merge(['uses' => 'Admin\FaqController@faqSortData'], $all_users))->name('faq.sort.data')->middleware('check_permission:manage_content,manage_faqs');
Route::put('faq-sort-update', array_merge(['uses' => 'Admin\FaqController@faqSortUpdate'], $all_users))->name('faq.sort.update')->middleware('check_permission:manage_content,manage_faqs');
/* * ****** End FAQ Field ********** */
?>