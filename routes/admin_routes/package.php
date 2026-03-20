<?php

/* * ******  Package Start ********** */
Route::get('list-packages', array_merge(['uses' => 'Admin\PackageController@indexPackages'], $all_users))->name('list.packages')->middleware('check_permission:view_packages');
Route::get('create-package', array_merge(['uses' => 'Admin\PackageController@createPackage'], $all_users))->name('create.package')->middleware('check_permission:create_packages');
Route::post('store-package', array_merge(['uses' => 'Admin\PackageController@storePackage'], $all_users))->name('store.package')->middleware('check_permission:create_packages');
Route::get('edit-package/{id}', array_merge(['uses' => 'Admin\PackageController@editPackage'], $all_users))->name('edit.package')->middleware('check_permission:edit_packages');
Route::put('update-package/{id}', array_merge(['uses' => 'Admin\PackageController@updatePackage'], $all_users))->name('update.package')->middleware('check_permission:edit_packages');
Route::delete('delete-package', array_merge(['uses' => 'Admin\PackageController@deletePackage'], $all_users))->name('delete.package')->middleware('check_permission:delete_packages');
Route::get('fetch-packages', array_merge(['uses' => 'Admin\PackageController@fetchPackagesData'], $all_users))->name('fetch.data.packages')->middleware('check_permission:view_packages');
/* * ****** End Package ********** */