<?php

$all_users = ['allowed_roles' => ['SUPER_ADMIN', 'SUB_ADMIN', 'CALL_CENTER']];

Route::group(['namespace' => 'Admin'], function () use ($all_users) {

    // Hizmet Kategorileri
    Route::get('/service-categories', array_merge(['uses' => 'ServiceCategoryController@index'], $all_users))->name('admin.service-categories.index')->middleware('check_permission:view_services,view_service_categories,view_caregiver_categories');
    Route::get('/service-categories/create', array_merge(['uses' => 'ServiceCategoryController@create'], $all_users))->name('admin.service-categories.create')->middleware('check_permission:manage_services');
    Route::post('/service-categories', array_merge(['uses' => 'ServiceCategoryController@store'], $all_users))->name('admin.service-categories.store')->middleware('check_permission:manage_services');
    Route::get('/service-categories/{id}/edit', array_merge(['uses' => 'ServiceCategoryController@edit'], $all_users))->name('admin.service-categories.edit')->middleware('check_permission:manage_services');
    Route::put('/service-categories/{id}', array_merge(['uses' => 'ServiceCategoryController@update'], $all_users))->name('admin.service-categories.update')->middleware('check_permission:manage_services');
    Route::delete('/service-categories/{id}', array_merge(['uses' => 'ServiceCategoryController@destroy'], $all_users))->name('admin.service-categories.destroy')->middleware('check_permission:manage_services');
    Route::post('/service-categories/{id}/toggle-status', array_merge(['uses' => 'ServiceCategoryController@toggleStatus'], $all_users))->name('admin.service-categories.toggle-status')->middleware('check_permission:manage_services');
    Route::post('/service-categories/{id}/update-options', array_merge(['uses' => 'ServiceCategoryController@updateOptions'], $all_users))->name('admin.service-categories.update-options')->middleware('check_permission:manage_services');
    Route::delete('/service-categories/delete-option/{id}', array_merge(['uses' => 'ServiceCategoryController@deleteOption'], $all_users))->name('admin.service-categories.delete-option')->middleware('check_permission:manage_services');

    // Hizmetler
    Route::get('/services', array_merge(['uses' => 'ServiceController@index'], $all_users))->name('admin.services.index')->middleware('check_permission:view_services,view_caregivers');
    Route::get('/services/create', array_merge(['uses' => 'ServiceController@create'], $all_users))->name('admin.services.create')->middleware('check_permission:manage_services');
    Route::post('/services', array_merge(['uses' => 'ServiceController@store'], $all_users))->name('admin.services.store')->middleware('check_permission:manage_services');
    Route::get('/services/{id}/edit', array_merge(['uses' => 'ServiceController@edit'], $all_users))->name('admin.services.edit')->middleware('check_permission:manage_services');
    Route::put('/services/{id}', array_merge(['uses' => 'ServiceController@update'], $all_users))->name('admin.services.update')->middleware('check_permission:manage_services');
    Route::delete('/services/{id}', array_merge(['uses' => 'ServiceController@destroy'], $all_users))->name('admin.services.destroy')->middleware('check_permission:manage_services');
    Route::post('/services/{id}/toggle-status', array_merge(['uses' => 'ServiceController@toggleStatus'], $all_users))->name('admin.services.toggle-status')->middleware('check_permission:manage_services');
    Route::post('/services/{id}/toggle-featured', array_merge(['uses' => 'ServiceController@toggleFeatured'], $all_users))->name('admin.services.toggle-featured')->middleware('check_permission:manage_services');

    // Ek Hizmetler
    Route::get('/service-addons', array_merge(['uses' => 'ServiceAddOnController@allAddons'], $all_users))->name('admin.service-addons.index')->middleware('check_permission:view_services,view_service_addons');
    Route::get('/service-addons/create', array_merge(['uses' => 'ServiceAddOnController@create'], $all_users))->name('admin.service-addons.create')->middleware('check_permission:manage_services');
    Route::get('/services/{serviceId}/add-ons', array_merge(['uses' => 'ServiceAddOnController@index'], $all_users))->name('admin.service-add-ons.index')->middleware('check_permission:view_services,view_service_addons');
    Route::post('/service-add-ons', array_merge(['uses' => 'ServiceAddOnController@store'], $all_users))->name('admin.service-add-ons.store')->middleware('check_permission:manage_services');
    Route::get('/service-add-ons/{id}/edit', array_merge(['uses' => 'ServiceAddOnController@edit'], $all_users))->name('admin.service-add-ons.edit')->middleware('check_permission:manage_services');
    Route::put('/service-add-ons/{id}', array_merge(['uses' => 'ServiceAddOnController@update'], $all_users))->name('admin.service-add-ons.update')->middleware('check_permission:manage_services');
    Route::delete('/service-add-ons/{id}', array_merge(['uses' => 'ServiceAddOnController@destroy'], $all_users))->name('admin.service-add-ons.destroy')->middleware('check_permission:manage_services');

    // Hizmet Talepleri
    Route::get('/service-requests', array_merge(['uses' => 'ServiceRequestController@index'], $all_users))->name('admin.service-requests.index')->middleware('check_permission:view_service_requests,view_caregiver_requests');
    Route::get('/service-requests/{id}', array_merge(['uses' => 'ServiceRequestController@show'], $all_users))->name('admin.service-requests.show')->middleware('check_permission:view_service_requests,view_caregiver_requests');
    Route::put('/service-requests/{id}/update-status', array_merge(['uses' => 'ServiceRequestController@updateStatus'], $all_users))->name('admin.service-requests.update-status')->middleware('check_permission:manage_service_requests,manage_services');
    Route::post('/service-requests/{id}/approve', array_merge(['uses' => 'ServiceRequestController@approve'], $all_users))->name('admin.service-requests.approve')->middleware('check_permission:manage_service_requests,manage_services');
    Route::post('/service-requests/{id}/complete', array_merge(['uses' => 'ServiceRequestController@complete'], $all_users))->name('admin.service-requests.complete')->middleware('check_permission:manage_service_requests,manage_services');
    Route::post('/service-requests/{id}/cancel', array_merge(['uses' => 'ServiceRequestController@cancel'], $all_users))->name('admin.service-requests.cancel')->middleware('check_permission:manage_service_requests,manage_services');
    Route::delete('/service-requests/{id}', array_merge(['uses' => 'ServiceRequestController@destroy'], $all_users))->name('admin.service-requests.destroy')->middleware('check_permission:manage_service_requests,manage_services');
    Route::get('/service-requests-statistics', array_merge(['uses' => 'ServiceRequestController@statistics'], $all_users))->name('admin.service-requests.statistics')->middleware('check_permission:view_service_requests,view_caregiver_requests');

    // Personel Atama
    Route::get('/service-requests-search-personnel', array_merge(['uses' => 'ServiceRequestController@searchPersonnel'], $all_users))->name('admin.service-requests.search-personnel')->middleware('check_permission:manage_service_requests,manage_services');
    Route::post('/service-requests/{id}/assign-personnel', array_merge(['uses' => 'ServiceRequestController@assignPersonnel'], $all_users))->name('admin.service-requests.assign-personnel')->middleware('check_permission:manage_service_requests,manage_services');
    Route::post('/service-requests/{id}/remove-personnel', array_merge(['uses' => 'ServiceRequestController@removePersonnel'], $all_users))->name('admin.service-requests.remove-personnel')->middleware('check_permission:manage_service_requests,manage_services');
});
