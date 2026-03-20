<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\User;
use App\ServiceRequest;
use App\Service;
use App\State;
use App\City;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

echo "Seeding example data for automation test...\n";

// 1. Create a Personnel
$personnel = User::updateOrCreate(
    ['email' => 'personnel1@example.com'],
    [
        'name' => 'Test Personnel 1',
        'first_name' => 'Test',
        'last_name' => 'Personnel 1',
        'password' => Hash::make('password123'),
        'verified' => 1,
        'is_active' => 1,
        'is_eligible_for_auto_assignment' => 1,
        'max_daily_tasks' => 5,
        'service_types' => [1], // Let's assume ID 1 is something common
        'work_locations' => [1, 2, 33, 34], // Some state IDs
        'availability_calendar' => [
            'monday' => ['active' => true, 'start' => '08:00', 'end' => '18:00'],
            'tuesday' => ['active' => true, 'start' => '08:00', 'end' => '18:00'],
            'wednesday' => ['active' => true, 'start' => '08:00', 'end' => '18:00'],
            'thursday' => ['active' => true, 'start' => '08:00', 'end' => '18:00'],
            'friday' => ['active' => true, 'start' => '08:00', 'end' => '18:00'],
        ]
    ]
);
echo "Created/Updated Personnel: personnel1@example.com\n";

// 2. Create a Customer
$customer = User::updateOrCreate(
    ['email' => 'customer1@example.com'],
    [
        'name' => 'Test Customer 1',
        'first_name' => 'Test',
        'last_name' => 'Customer 1',
        'password' => Hash::make('password123'),
        'verified' => 1,
        'is_active' => 1,
    ]
);
echo "Created/Updated Customer: customer1@example.com\n";

// 3. Create a Service Request
$service = Service::first();
if (!$service) {
    echo "NO SERVICES FOUND. PLEASE CREATE SERVICES FIRST.\n";
    exit;
}

$state = State::where('id', 34)->first() ?? State::first();

$request = ServiceRequest::create([
    'request_number' => 'REQ-' . strtoupper(\Illuminate\Support\Str::random(8)),
    'user_id' => $customer->id,
    'service_id' => $service->id,
    'customer_name' => $customer->name,
    'customer_email' => $customer->email,
    'customer_phone' => '5551234567',
    'customer_address' => 'Test Mah. Örnek Cad. No:1',
    'customer_city' => 34, // İstanbul
    'customer_district' => 450, // Beşiktaş (assuming ID)
    'service_date' => Carbon::now()->addDay()->format('Y-m-d'), // Tomorrow
    'service_time' => '10:00',
    'preferred_date' => Carbon::now()->addDay()->format('Y-m-d'),
    'preferred_time' => '10:00',
    'automation_status' => 'pending_matching',
    'status' => 'pending',
    'home_size' => '2+1',
    'service_duration' => '4'
]);

echo "Created Service Request: #{$request->request_number}\n";
echo "\nNow you can run: php artisan matching:process\n";
