<?php

/* * ******  Video Start ********** */
Route::get('list-videos', array_merge(['uses' => 'Admin\VideoController@indexVideos'], $all_users))->name('list.videos')->middleware('check_permission:manage_content,manage_videos');
Route::get('create-video', array_merge(['uses' => 'Admin\VideoController@createVideo'], $all_users))->name('create.video')->middleware('check_permission:manage_content,manage_videos');
Route::post('store-video', array_merge(['uses' => 'Admin\VideoController@storeVideo'], $all_users))->name('store.video')->middleware('check_permission:manage_content,manage_videos');
Route::get('edit-video/{id}', array_merge(['uses' => 'Admin\VideoController@editVideo'], $all_users))->name('edit.video')->middleware('check_permission:manage_content,manage_videos');
Route::put('update-video/{id}', array_merge(['uses' => 'Admin\VideoController@updateVideo'], $all_users))->name('update.video')->middleware('check_permission:manage_content,manage_videos');
Route::delete('delete-video', array_merge(['uses' => 'Admin\VideoController@deleteVideo'], $all_users))->name('delete.video')->middleware('check_permission:manage_content,manage_videos');
Route::get('fetch-videos', array_merge(['uses' => 'Admin\VideoController@fetchVideosData'], $all_users))->name('fetch.data.videos')->middleware('check_permission:manage_content,manage_videos');
Route::put('make-active-video', array_merge(['uses' => 'Admin\VideoController@makeActiveVideo'], $all_users))->name('make.active.video')->middleware('check_permission:manage_content,manage_videos');
Route::put('make-not-active-video', array_merge(['uses' => 'Admin\VideoController@makeNotActiveVideo'], $all_users))->name('make.not.active.video')->middleware('check_permission:manage_content,manage_videos');
Route::get('sort-videos', array_merge(['uses' => 'Admin\VideoController@sortVideos'], $all_users))->name('sort.videos')->middleware('check_permission:manage_content,manage_videos');
Route::get('video-sort-data', array_merge(['uses' => 'Admin\VideoController@videoSortData'], $all_users))->name('video.sort.data')->middleware('check_permission:manage_content,manage_videos');
Route::put('video-sort-update', array_merge(['uses' => 'Admin\VideoController@videoSortUpdate'], $all_users))->name('video.sort.update')->middleware('check_permission:manage_content,manage_videos');
/* * ****** End Video ********** */