<?php

// Evine Hizmet Al - Frontend Routes

Route::group(['prefix' => 'evine-hizmet-al'], function () {
    // Ana sayfa
    Route::get('/', 'HomeServiceController@index')->name('home-services.index')->defaults('type', 'service');
    // Tüm hizmetler
    Route::get('/hizmetler', 'HomeServiceController@allServices')->name('home-services.all')->defaults('type', 'service');
    // Kategori sayfası
    Route::get('/kategori/{slug}', 'HomeServiceController@category')->name('home-services.category')->defaults('type', 'service');
    // Hizmet detay sayfası
    Route::get('/hizmet/{slug}', 'HomeServiceController@show')->name('home-services.show');
    // Hizmet talep formu
    Route::get('/hizmet/{slug}/talep', 'HomeServiceController@requestForm')->name('home-services.request-form');
    // Hizmet talebi gönder
    Route::post('/hizmet/{slug}/talep', 'HomeServiceController@submitRequest')->name('home-services.submit-request');
});

// Wizard Routes
Route::get('/talep-sihirbazi/{type?}', 'HomeServiceController@wizard')->name('services.wizard');
Route::get('/wizard/get-options', 'HomeServiceController@getCategoryOptions')->name('wizard.get-options');
Route::post('/wizard/submit', 'HomeServiceController@submitWizard')->name('wizard.submit');

Route::group(['prefix' => 'bakici-bul'], function () {
    // Ana sayfa
    Route::get('/', 'HomeServiceController@index')->name('caregiver.index')->defaults('type', 'caregiver');
    // Tüm hizmetler
    Route::get('/bakici-turleri', 'HomeServiceController@allServices')->name('caregiver.all')->defaults('type', 'caregiver');
    // Kategori sayfası
    Route::get('/kategori/{slug}', 'HomeServiceController@category')->name('caregiver.category')->defaults('type', 'caregiver');
    // Hizmet detay sayfası
    Route::get('/bakici/{slug}', 'HomeServiceController@show')->name('caregiver.show');
    // Hizmet talep formu
    Route::get('/bakici/{slug}/talep', 'HomeServiceController@requestForm')->name('caregiver.request-form');
    // Hizmet talebi gönder
    Route::post('/bakici/{slug}/talep', 'HomeServiceController@submitRequest')->name('caregiver.submit-request');
});

// Common Routes
Route::get('/home-services/get-cities', 'HomeServiceController@getCities')->name('home-services.get-cities');
Route::get('/home-services/taleplerim', 'HomeServiceController@myRequests')->name('home-services.my-requests');
Route::get('/home-services/taleplerim/{requestNumber}', 'HomeServiceController@requestDetail')->name('home-services.request-detail');
Route::post('/home-services/taleplerim/{requestNumber}/iptal', 'HomeServiceController@cancelRequest')->name('home-services.cancel-request');
