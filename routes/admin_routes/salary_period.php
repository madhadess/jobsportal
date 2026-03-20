<?php

/* * ******  SalaryPeriod Start ********** */
Route::get('list-salary-periods', array_merge(['uses' => 'Admin\SalaryPeriodController@indexSalaryPeriods'], $all_users))->middleware('check_permission:manage_definitions')->name('list.salary.periods');
Route::get('create-salary-period', array_merge(['uses' => 'Admin\SalaryPeriodController@createSalaryPeriod'], $all_users))->middleware('check_permission:manage_definitions')->name('create.salary.period');
Route::post('store-salary-period', array_merge(['uses' => 'Admin\SalaryPeriodController@storeSalaryPeriod'], $all_users))->middleware('check_permission:manage_definitions')->name('store.salary.period');
Route::get('edit-salary-period/{id}', array_merge(['uses' => 'Admin\SalaryPeriodController@editSalaryPeriod'], $all_users))->middleware('check_permission:manage_definitions')->name('edit.salary.period');
Route::put('update-salary-period/{id}', array_merge(['uses' => 'Admin\SalaryPeriodController@updateSalaryPeriod'], $all_users))->middleware('check_permission:manage_definitions')->name('update.salary.period');
Route::delete('delete-salary-period', array_merge(['uses' => 'Admin\SalaryPeriodController@deleteSalaryPeriod'], $all_users))->middleware('check_permission:manage_definitions')->name('delete.salary.period');
Route::get('fetch-salary.periods', array_merge(['uses' => 'Admin\SalaryPeriodController@fetchSalaryPeriodsData'], $all_users))->middleware('check_permission:manage_definitions')->name('fetch.data.salary.periods');
Route::put('make-active-salary-period', array_merge(['uses' => 'Admin\SalaryPeriodController@makeActiveSalaryPeriod'], $all_users))->middleware('check_permission:manage_definitions')->name('make.active.salary.period');
Route::put('make-not-active-salary-period', array_merge(['uses' => 'Admin\SalaryPeriodController@makeNotActiveSalaryPeriod'], $all_users))->middleware('check_permission:manage_definitions')->name('make.not.active.salary.period');
Route::get('sort-salary-periods', array_merge(['uses' => 'Admin\SalaryPeriodController@sortSalaryPeriods'], $all_users))->middleware('check_permission:manage_definitions')->name('sort.salary.periods');
Route::get('salary-period-sort-data', array_merge(['uses' => 'Admin\SalaryPeriodController@salaryPeriodSortData'], $all_users))->middleware('check_permission:manage_definitions')->name('salary.period.sort.data');
Route::put('salary-period-sort-update', array_merge(['uses' => 'Admin\SalaryPeriodController@salaryPeriodSortUpdate'], $all_users))->middleware('check_permission:manage_definitions')->name('salary.period.sort.update');
/* * ****** End SalaryPeriod ********** */