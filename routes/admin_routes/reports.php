<?php

$all_users = ['allowed_roles' => ['SUPER_ADMIN', 'SUB_ADMIN', 'CALL_CENTER']];

Route::group(['namespace' => 'Admin', 'prefix' => 'reports'], function () use ($all_users) {

    // Ana raporlama dashboard
    Route::get('/', array_merge(['uses' => 'ReportsController@index'], $all_users))->name('admin.reports.index')->middleware('check_permission:view_reports');

    // İş ilanları raporu
    Route::get('/jobs', array_merge(['uses' => 'ReportsController@jobs'], $all_users))->name('admin.reports.jobs')->middleware('check_permission:view_reports');
    Route::get('/jobs/export', array_merge(['uses' => 'ReportsController@exportJobs'], $all_users))->name('admin.reports.jobs.export')->middleware('check_permission:export_reports');

    // Şirketler raporu
    Route::get('/companies', array_merge(['uses' => 'ReportsController@companies'], $all_users))->name('admin.reports.companies')->middleware('check_permission:view_reports');
    Route::get('/companies/export', array_merge(['uses' => 'ReportsController@exportCompanies'], $all_users))->name('admin.reports.companies.export')->middleware('check_permission:export_reports');

    // Başvuralar raporu
    Route::get('/applications', array_merge(['uses' => 'ReportsController@applications'], $all_users))->name('admin.reports.applications')->middleware('check_permission:view_reports');
    Route::get('/applications/export', array_merge(['uses' => 'ReportsController@exportApplications'], $all_users))->name('admin.reports.applications.export')->middleware('check_permission:export_reports');

    // Hizmetler raporu
    Route::get('/services', array_merge(['uses' => 'ReportsController@services'], $all_users))->name('admin.reports.services')->middleware('check_permission:view_reports');
    Route::get('/services/export', array_merge(['uses' => 'ReportsController@exportServices'], $all_users))->name('admin.reports.services.export')->middleware('check_permission:export_reports');

    // Hizmet talepleri raporu
    Route::get('/service-requests', array_merge(['uses' => 'ReportsController@serviceRequests'], $all_users))->name('admin.reports.service_requests')->middleware('check_permission:view_reports');
    Route::get('/service-requests/export', array_merge(['uses' => 'ReportsController@exportServiceRequests'], $all_users))->name('admin.reports.service_requests.export')->middleware('check_permission:export_reports');

    // Mail Testi
    Route::get('/test-mail', array_merge(['uses' => 'ReportsController@testMail'], $all_users))->name('admin.reports.test_mail');

});
