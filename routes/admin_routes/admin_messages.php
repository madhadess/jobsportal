<?php

Route::group(['middleware' => ['admin_activity']], function () {
    Route::get('messages', 'Admin\AdminMessageController@index')->name('admin.messages.index');
    Route::get('messages/history/{admin_id}', 'Admin\AdminMessageController@getHistory')->name('admin.messages.history');
    Route::post('messages/send', 'Admin\AdminMessageController@sendMessage')->name('admin.messages.send');
    Route::get('messages/unread-count', 'Admin\AdminMessageController@getUnreadCount')->name('admin.messages.unreadCount');
    Route::get('messages/recent', 'Admin\AdminMessageController@getRecentMessages')->name('admin.messages.recent');
});
