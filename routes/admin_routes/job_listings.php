<?php

// ─── ADMIN ROUTES — Job Listings Module ────────────────────────────────────

Route::group([
    'prefix' => 'ilanlar',
    'namespace' => 'Admin',
    'middleware' => ['allowed_roles:SUPER_ADMIN,SUB_ADMIN,CALL_CENTER'],
    'as' => 'admin.job-posts.',
], function () {
    Route::get('/', 'JobPostAdminController@index')->name('index');
    Route::get('/{id}', 'JobPostAdminController@show')->name('show');
    Route::post('/{id}/askiya-al', 'JobPostAdminController@suspend')->name('suspend');
    Route::post('/{id}/yayinla', 'JobPostAdminController@publish')->name('publish');
    Route::post('/{id}/kapat', 'JobPostAdminController@close')->name('close');
    Route::get('/istatistik', 'JobPostAdminController@stats')->name('stats');
});

Route::group([
    'prefix' => 'basvurular',
    'namespace' => 'Admin',
    'middleware' => ['allowed_roles:SUPER_ADMIN,SUB_ADMIN,CALL_CENTER'],
    'as' => 'admin.applications.',
], function () {
    Route::get('/', 'ApplicationAdminController@index')->name('index');
    Route::get('/{id}', 'ApplicationAdminController@show')->name('show');
    Route::post('/{id}/onayla', 'ApplicationAdminController@approve')->name('approve');
});

Route::group([
    'prefix' => 'eslesme-kurallari',
    'namespace' => 'Admin',
    'middleware' => ['allowed_roles:SUPER_ADMIN'],
    'as' => 'admin.match-rules.',
], function () {
    Route::get('/', 'MatchRuleController@index')->name('index');
    Route::put('/{id}', 'MatchRuleController@update')->name('update');
    Route::post('/sifirla', 'MatchRuleController@reset')->name('reset');
});
