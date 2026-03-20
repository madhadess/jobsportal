<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Services count: " . \App\Service::count() . "\n";
$services = \App\Service::take(10)->get(['id', 'service_name', 'is_active']);
foreach ($services as $s) {
    echo "ID: {$s->id} | {$s->service_name} | active={$s->is_active}\n";
}

if (\App\Service::count() == 0) {
    echo "\n--- NO SERVICES FOUND ---\n";
    echo "Checking service_categories instead:\n";
    $cats = \App\ServiceCategory::take(10)->get();
    foreach ($cats as $c) {
        echo "Cat ID: {$c->id} | {$c->category_name}\n";
    }
}
