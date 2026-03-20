<?php



/* * ******  Company Start ********** */

Route::get('list-companies', array_merge(['uses' => 'Admin\CompanyController@indexCompanies'], $all_users))->name('list.companies')->middleware('check_permission:view_companies');

Route::get('list-payment-history', array_merge(['uses' => 'Admin\CompanyController@indexCompaniesHistory'], $all_users))->name('list.payment.hostory')->middleware('check_permission:view_companies,view_orders');
Route::get('public-job/{id}', 'AjaxController@jobdetail')->name('public.job');
Route::get('fetch-payment-history', array_merge(['uses' => 'Admin\CompanyController@fetchCompaniesHistory'], $all_users))->name('fetch.data.companiesHistory')->middleware('check_permission:view_companies,view_orders');

Route::get('create-company', array_merge(['uses' => 'Admin\CompanyController@createCompany'], $all_users))->name('create.company')->middleware('check_permission:create_companies');

Route::post('store-company', array_merge(['uses' => 'Admin\CompanyController@storeCompany'], $all_users))->name('store.company')->middleware('check_permission:create_companies');

Route::get('edit-company/{id}', array_merge(['uses' => 'Admin\CompanyController@editCompany'], $all_users))->name('edit.company')->middleware('check_permission:edit_companies');

Route::get('detail-company/{id}', array_merge(['uses' => 'Admin\CompanyController@detailCompany'], $all_users))->name('detail.company')->middleware('check_permission:view_companies');

Route::post('assign-company-package/{id}', array_merge(['uses' => 'Admin\CompanyController@assignCompanyPackage'], $all_users))->name('assign.company.package')->middleware('check_permission:edit_companies');

Route::post('assign-cv-package/{id}', array_merge(['uses' => 'Admin\CompanyController@assignCvPackage'], $all_users))->name('assign.cv.package')->middleware('check_permission:edit_companies');

Route::post('change-document-status/{id}', array_merge(['uses' => 'Admin\CompanyController@changeStatus'], $all_users))->name('edit.changeStatus')->middleware('check_permission:verify_companies');

Route::put('update-company/{id}', array_merge(['uses' => 'Admin\CompanyController@updateCompany'], $all_users))->name('update.company')->middleware('check_permission:edit_companies');

Route::delete('delete-company', array_merge(['uses' => 'Admin\CompanyController@deleteCompany'], $all_users))->name('delete.company')->middleware('check_permission:delete_companies');

Route::get('fetch-companies', array_merge(['uses' => 'Admin\CompanyController@fetchCompaniesData'], $all_users))->name('fetch.data.companies')->middleware('check_permission:view_companies');

Route::put('make-active-company', array_merge(['uses' => 'Admin\CompanyController@makeActiveCompany'], $all_users))->name('make.active.company')->middleware('check_permission:edit_companies');

Route::put('make-not-active-company', array_merge(['uses' => 'Admin\CompanyController@makeNotActiveCompany'], $all_users))->name('make.not.active.company')->middleware('check_permission:edit_companies');

Route::put('make-featured-company', array_merge(['uses' => 'Admin\CompanyController@makeFeaturedCompany'], $all_users))->name('make.featured.company')->middleware('check_permission:edit_companies');

Route::put('make-not-featured-company', array_merge(['uses' => 'Admin\CompanyController@makeNotFeaturedCompany'], $all_users))->name('make.not.featured.company')->middleware('check_permission:edit_companies');



Route::get('list-applied-users/{job_id}', array_merge(['uses' => 'Admin\CompanyController@listAppliedUsers'], $all_users))->name('admin.list.applied.users')->middleware('check_permission:view_companies,view_jobs');


/* * ****** End Company ********** */