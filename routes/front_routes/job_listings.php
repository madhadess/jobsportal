<?php

// ─── FRONT ROUTES — Job Listings Module ─────────────────────────────────────

// ─── Hizmet Alan (Member): İlan Yönetimi ────────────────────────────────────
Route::group(['middleware' => ['auth'], 'prefix' => 'ilanlarim', 'as' => 'job-posts.'], function () {
    Route::get('/', 'JobPostController@index')->name('index');
    Route::get('/olustur', 'JobPostController@create')->name('create');
    Route::post('/', 'JobPostController@store')->name('store');
    Route::get('/get-cities', 'JobPostController@getCities')->name('get-cities');
    Route::get('/{id}', 'JobPostController@show')->name('show');
    Route::get('/{id}/duzenle', 'JobPostController@edit')->name('edit');
    Route::put('/{id}', 'JobPostController@update')->name('update');
    Route::post('/{id}/yayinla', 'JobPostController@publish')->name('publish');
    Route::post('/{id}/kapat', 'JobPostController@close')->name('close');
    Route::post('/{id}/iptal', 'JobPostController@cancel')->name('cancel');

    // Aday Yönetimi
    Route::get('/{postId}/adaylar', 'CandidateController@index')->name('candidates');
    Route::post('/{postId}/adaylar/{appId}/kisalisteye', 'CandidateController@shortlist')->name('candidates.shortlist');
    Route::post('/{postId}/adaylar/{appId}/davet', 'CandidateController@invite')->name('candidates.invite');
    Route::post('/{postId}/adaylar/{appId}/kabul', 'CandidateController@accept')->name('candidates.accept');
    Route::post('/{postId}/adaylar/{appId}/reddet', 'CandidateController@reject')->name('candidates.reject');
});

// ─── Personel / Bakıcı: İlanlar & Başvurular ────────────────────────────────
Route::group(['middleware' => ['auth'], 'prefix' => 'ilanlar', 'as' => 'listings.'], function () {
    Route::get('/', 'ApplicationController@browse')->name('browse');
    Route::get('/{id}', 'ApplicationController@show')->name('show');
    Route::post('/{id}/basvur', 'ApplicationController@apply')->name('apply');
    Route::post('/{id}/vazgec', 'ApplicationController@withdraw')->name('withdraw');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'basvurularim', 'as' => 'my-applications.'], function () {
    Route::get('/', 'ApplicationController@myApplications')->name('index');
    Route::get('/{id}', 'ApplicationController@applicationDetail')->name('show');
});
