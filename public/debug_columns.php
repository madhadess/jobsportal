<?php
// debug_columns.php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\Schema;

echo "<h1>Admins Table Columns</h1>";
$columns = Schema::getColumnListing('admins');
echo "<pre>";
print_r($columns);
echo "</pre>";
