<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\ServiceRequest;

echo "Listing and Resetting Service Requests...\n";
$requests = ServiceRequest::whereNotNull('automation_status')->get();
foreach ($requests as $r) {
    echo "{$r->request_number} : {$r->automation_status} : {$r->status}\n";
    $r->update([
        'automation_status' => 'pending_matching',
        'matching_attempts' => 0,
        'status' => 'pending'
    ]);
}
echo "Reset " . $requests->count() . " requests.\n";
