<?php

$all_users = ['allowed_roles' => ['SUPER_ADMIN', 'SUB_ADMIN', 'CALL_CENTER']];
$all_users = ['allowed_roles' => ['SUPER_ADMIN', 'SUB_ADMIN', 'CALL_CENTER']];

Route::get('campaigns', array_merge(['uses' => 'Admin\CampaignController@index'], $all_users))->name('admin.campaign.index')->middleware('check_permission:manage_campaigns');
Route::post('campaigns/send', array_merge(['uses' => 'Admin\CampaignController@send'], $all_users))->name('admin.campaign.send')->middleware('check_permission:manage_campaigns');
