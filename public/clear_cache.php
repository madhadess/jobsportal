<?php
/**
 * Cache Temizleme Scripti
 * ÖNEMLİ: İşlem bittikten sonra bu dosyayı silin!
 */

// Laravel bootstrap
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h2>Cache Temizleme</h2>";

// Config cache temizle
try {
    Artisan::call('config:clear');
    echo "<p>✅ Config cache temizlendi</p>";
} catch (Exception $e) {
    echo "<p>❌ Config cache hatası: " . $e->getMessage() . "</p>";
}

// View cache temizle
try {
    Artisan::call('view:clear');
    echo "<p>✅ View cache temizlendi</p>";
} catch (Exception $e) {
    echo "<p>❌ View cache hatası: " . $e->getMessage() . "</p>";
}

// Application cache temizle
try {
    Artisan::call('cache:clear');
    echo "<p>✅ Application cache temizlendi</p>";
} catch (Exception $e) {
    echo "<p>❌ Application cache hatası: " . $e->getMessage() . "</p>";
}

// Route cache temizle
try {
    Artisan::call('route:clear');
    echo "<p>✅ Route cache temizlendi</p>";
} catch (Exception $e) {
    echo "<p>❌ Route cache hatası: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><strong>İşlem tamamlandı!</strong></p>";
echo "<p style='color:red;'><strong>GÜVENLİK: Bu dosyayı sunucudan silin!</strong></p>";
