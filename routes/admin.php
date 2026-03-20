<?php

$all_users = ['allowed_roles' => ['SUPER_ADMIN', 'SUB_ADMIN', 'CALL_CENTER']];
$sup_only = ['allowed_roles' => 'SUPER_ADMIN'];
Route::get('/home', array_merge(['uses' => 'Admin\HomeController@index'], $all_users))->name('admin.home');
Route::post('tinymce-image_upload', array_merge(['uses' => 'Admin\TinyMceController@uploadImage'], $all_users))->name('tinymce.image_upload');
Route::get('clear-cache-system', array_merge(['uses' => 'Admin\HomeController@clearCache'], $sup_only))->name('admin.clear.cache');
/* * ********************************* */
$real_path = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'admin_routes' . DIRECTORY_SEPARATOR;
include_once($real_path . 'admin_user.php');
include_once($real_path . 'site_user.php');
include_once($real_path . 'faq.php');
include_once($real_path . 'seo.php');
include_once($real_path . 'cms.php');
include_once($real_path . 'site_setting.php');
include_once($real_path . 'career_level.php');
include_once($real_path . 'country.php');
include_once($real_path . 'country_detail.php');
include_once($real_path . 'functional_area.php');
include_once($real_path . 'gender.php');
include_once($real_path . 'industry.php');
include_once($real_path . 'job_experience.php');
include_once($real_path . 'job_skill.php');
include_once($real_path . 'job_title.php');
include_once($real_path . 'job_type.php');
include_once($real_path . 'job_shift.php');
include_once($real_path . 'degree_level.php');
include_once($real_path . 'degree_type.php');
include_once($real_path . 'major_subject.php');
include_once($real_path . 'language.php');
include_once($real_path . 'state.php');
include_once($real_path . 'city.php');
include_once($real_path . 'result_type.php');
include_once($real_path . 'language_level.php');
include_once($real_path . 'marital_status.php');
include_once($real_path . 'company.php');
include_once($real_path . 'ownership_type.php');
include_once($real_path . 'job.php');
include_once($real_path . 'salary_period.php');
include_once($real_path . 'package.php');
include_once($real_path . 'video.php');
include_once($real_path . 'testimonial.php');
include_once($real_path . 'slider.php');
include_once($real_path . 'home_services.php');
include_once($real_path . 'reports.php');
include_once($real_path . 'crm.php');
include_once($real_path . 'security.php');
include_once($real_path . 'admin_messages.php');
include_once($real_path . 'campaign.php');
include_once($real_path . 'automation.php');
include_once($real_path . 'job_listings.php');

Route::group(['namespace' => 'Admin'], function () {
    Route::get('/blog_category', 'Blog_categoriesController@index')->middleware('check_permission:manage_blog');
    Route::post('/blog_category/create', 'Blog_categoriesController@create')->middleware('check_permission:manage_blog');
    Route::post('/blog_category', 'Blog_categoriesController@update')->middleware('check_permission:manage_blog');
    Route::delete('/blog_category/{blog_category}', 'Blog_categoriesController@destroy')->middleware('check_permission:manage_blog');
    Route::get('/blog_category/get_blog_category_by_id/{blog_category}', 'Blog_categoriesController@get_blog_category_by_id')->middleware('check_permission:manage_blog');

    Route::get('/blog', 'BlogsController@index')->name('blog')->middleware('check_permission:manage_blog,view_blog');
    Route::get('/blog/add-new-blog', 'BlogsController@show_form')->name('add-new-blog')->middleware('check_permission:manage_blog');
    Route::post('/blog/create', 'BlogsController@create')->middleware('check_permission:manage_blog');
    Route::post('/blog/update', 'BlogsController@update')->middleware('check_permission:manage_blog');
    Route::delete('/blog/{blog}', 'BlogsController@destroy')->middleware('check_permission:manage_blog');
    Route::get('/blog/remove_blog_feature_image/{blog}', 'BlogsController@remove_blog_feature_image')->middleware('check_permission:manage_blog');
    Route::get('/blog/get_blog_by_id/{blog}', 'BlogsController@get_blog_by_id')->middleware('check_permission:manage_blog');
    Route::get('/blog/edit-blog/{blog}', 'BlogsController@get_blog')->name('edit-blog')->middleware('check_permission:manage_blog');



    /*Widget Page routes Start*/

    Route::get('/widget-pages', 'WidgetPagesController@index')->name('admin.widget_pages')->middleware('check_permission:manage_content');

    Route::get('/add-widget-page', 'WidgetPagesController@add')->name('admin.widget_pages.add')->middleware('check_permission:manage_content');

    Route::post('/store-widget-page', 'WidgetPagesController@store')->name('admin.widget_pages.store')->middleware('check_permission:manage_content');

    Route::post('/update-widget-page', 'WidgetPagesController@update')->name('admin.widget_pages.update')->middleware('check_permission:manage_content');

    Route::get('/edit-widget-page/{widget_page}', 'WidgetPagesController@edit')->name('admin.widget_pages.edit')->middleware('check_permission:manage_content');

    Route::get('/delete-widget-page/{widget_page}', 'WidgetPagesController@destroy')->name('admin.widget_pages.delete')->middleware('check_permission:manage_content');

    /*Widget Page routes End*/

    /*Widget routes Start*/

    Route::get('/widgets', 'WidgetsController@index')->name('admin.widgets')->middleware('check_permission:manage_content');

    Route::get('/add-widget', 'WidgetsController@add')->name('admin.widgets.add')->middleware('check_permission:manage_content');

    Route::post('/store-widget', 'WidgetsController@store')->name('admin.widgets.store')->middleware('check_permission:manage_content');

    Route::post('/update-widget', 'WidgetsController@update')->name('admin.widgets.update')->middleware('check_permission:manage_content');

    Route::get('/edit-widget/{widget}', 'WidgetsController@edit')->name('admin.widgets.edit')->middleware('check_permission:manage_content');

    Route::get('/delete-widget/{widget}', 'WidgetsController@destroy')->name('admin.widgets.delete')->middleware('check_permission:manage_content');

    /*Widget routes End*/

    /*Widget data routes Start*/

    Route::get('/page/{page}', 'WidgetDataController@index')->name('admin.widgets_data')->middleware('check_permission:manage_content');


    Route::post('/store-widget-data/{id}', 'WidgetDataController@store')->name('admin.widget_data.store')->middleware('check_permission:manage_content');

    Route::post('/update-widget-page', 'WidgetDataController@update')->name('admin.widget_pages.update')->middleware('check_permission:manage_content');


    Route::get('/delete-widget-page/{widget_page}', 'WidgetPagesController@destroy')->name('admin.widget_pages.delete')->middleware('check_permission:manage_content');

    /*Widget data routes End*/



    /* Role routes Start */
    Route::group(['middleware' => ['allowed_roles:SUPER_ADMIN,SUB_ADMIN,CALL_CENTER']], function () {
        Route::get('/roles', 'RoleController@index')->name('admin.roles.index')->middleware('check_permission:manage_roles');
        Route::get('/roles/create', 'RoleController@create')->name('admin.roles.create')->middleware('check_permission:manage_roles');
        Route::post('/roles/store', 'RoleController@store')->name('admin.roles.store')->middleware('check_permission:manage_roles');
        Route::get('/roles/edit/{id}', 'RoleController@edit')->name('admin.roles.edit')->middleware('check_permission:manage_roles');
        Route::post('/roles/update/{id}', 'RoleController@update')->name('admin.roles.update')->middleware('check_permission:manage_roles');
        Route::delete('/roles/delete', 'RoleController@destroy')->name('admin.roles.delete')->middleware('check_permission:manage_roles');
        Route::get('/roles/fetch', 'RoleController@fetchRolesData')->name('admin.roles.fetch')->middleware('check_permission:manage_roles');
    });
    /* Role routes End */

    Route::post('assign-featured-package/{company_id}', 'CompanyController@assignFeaturedPackage')->name('assign.featured.package');
});
