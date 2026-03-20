<?php

use Illuminate\Support\Facades\Artisan;

// Basic security check (Optional: remove if it blocks you)
// if (php_sapi_name() !== 'cli') {
//     die('This script should be run via browser only if terminal fails.');
// }

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<h1>Migration Fix Script</h1>";

$migrations = [
    'database/migrations/2026_02_23_000000_change_occupation_group_id_type_in_users_table.php',
    'database/migrations/2026_02_23_000001_create_job_posts_table.php',
    'database/migrations/2026_02_23_000002_create_job_post_requirements_table.php',
    'database/migrations/2026_02_23_000003_create_listing_applications_table.php',
    'database/migrations/2026_02_23_000004_create_application_status_history_table.php',
    'database/migrations/2026_02_23_000005_create_match_scores_table.php',
    'database/migrations/2026_02_23_000006_create_match_rule_weights_table.php',
];

foreach ($migrations as $m) {
    echo "<b>Running:</b> $m <br>";
    try {
        Artisan::call('migrate', [
            '--path' => $m,
            '--force' => true
        ]);
        echo "<span style='color:green'>SUCCESS</span><br>";
        echo "<pre style='background:#f4f4f4; padding:5px;'>" . Artisan::output() . "</pre>";
    } catch (\Exception $e) {
        echo "<span style='color:red'>ERROR:</span> " . $e->getMessage() . "<br><br>";
    }
    echo "<hr>";
}

echo "<br><b>İşlem Tamamlandı. Lütfen sayfayı yenileyip her şeyin YEŞİL (SUCCESS) olduğunu teyit edin.</b><br>";
echo "Eğer hala hata alıyorsanız, lütfen hata mesajını bana iletin.";
