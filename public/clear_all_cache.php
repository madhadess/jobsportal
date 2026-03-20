<?php
/**
 * Tüm Cache Temizleme Scripti
 * ÖNEMLİ: İşlem bittikten sonra bu dosyayı sunucudan silin!
 */

echo "<h2>🧹 Tüm Cache Temizleme</h2>";
echo "<style>body{font-family:Arial,sans-serif;padding:20px;} .ok{color:green;} .error{color:red;}</style>";

// Temizlenecek klasörler
$cacheDirs = [
    'storage/framework/cache' => 'Application Cache',
    'storage/framework/views' => 'View Cache', 
    'storage/framework/sessions' => 'Session Cache',
    'bootstrap/cache' => 'Bootstrap Cache'
];

$success = true;

foreach ($cacheDirs as $dir => $name) {
    echo "<p><strong>$name:</strong> ";
    
    if (is_dir($dir)) {
        $files = glob($dir . '/*');
        $deleted = 0;
        $errors = 0;
        
        foreach ($files as $file) {
            try {
                if (is_file($file)) {
                    unlink($file);
                    $deleted++;
                } elseif (is_dir($file)) {
                    // Alt klasörleri de sil
                    $subFiles = glob($file . '/*');
                    foreach ($subFiles as $subFile) {
                        if (is_file($subFile)) {
                            unlink($subFile);
                            $deleted++;
                        }
                    }
                    rmdir($file);
                }
            } catch (Exception $e) {
                $errors++;
            }
        }
        
        if ($errors > 0) {
            echo "<span class='error'>$deleted dosya silindi, $errors hata</span></p>";
        } else {
            echo "<span class='ok'>$deleted dosya silindi ✅</span></p>";
        }
    } else {
        echo "<span class='error'>Klasör bulunamadı ❌</span></p>";
        $success = false;
    }
}

// Özel dosyaları sil
$specialFiles = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/routes.php',
    'bootstrap/cache/packages.php',
    'bootstrap/cache/services.php'
];

echo "<h3>Özel Cache Dosyaları:</h3>";
foreach ($specialFiles as $file) {
    echo "<p><strong>$file:</strong> ";
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "<span class='ok'>Silindi ✅</span></p>";
        } else {
            echo "<span class='error'>Silinemedi ❌</span></p>";
            $success = false;
        }
    } else {
        echo "<span class='ok'>Zaten yok ✅</span></p>";
    }
}

// Sonuç
echo "<hr>";
if ($success) {
    echo "<h2 class='ok'>✅ Tüm cache başarıyla temizlendi!</h2>";
    echo "<p>Sayfayı yenileyebilirsiniz.</p>";
} else {
    echo "<h2 class='error'>⚠️ Bazı dosyalar silinemedi</h2>";
    echo "<p>FTP izinlerini kontrol edin.</p>";
}

echo "<hr>";
echo "<p style='color:red;'><strong>⚠️ GÜVENLİK: Bu dosyayı sunucudan silin!</strong></p>";
echo "<p><a href='javascript:history.back()'>Geri Dön</a></p>";
?>
