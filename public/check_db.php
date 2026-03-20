<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "<pre>";
echo "DB_DATABASE: " . env('DB_DATABASE') . "\n";
echo "DB_HOST: " . env('DB_HOST') . "\n";
echo "DB_USERNAME: " . env('DB_USERNAME') . "\n";

try {
    $res = DB::select("SELECT DATABASE()");
    echo "Actual Connected Database: " . $res[0]->{'DATABASE()'} . "\n";
    $hasColumn = Schema::hasColumn('service_requests', 'automation_status');
    echo "automation_status found: " . ($hasColumn ? "YES" : "NO") . "\n";

    if (!$hasColumn) {
        echo "\nListing all columns in service_requests:\n";
        $columns = Schema::getColumnListing('service_requests');
        print_r($columns);
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
echo "</pre>";
