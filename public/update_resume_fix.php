<?php
/**
 * Yetkilendirme güncellemesini tarayıcıdan çalıştırır.
 * Laravel rotasına ihtiyaç yok; bu dosyayı public/ içine atıp doğrudan açın.
 *
 * cPanel: Bu dosyayı PUBLIC klasörüne yükleyin (index.php ile aynı yere).
 * Adres: https://site.com/run-permissions-update.php
 *
 * Gereksinim: Proje kökünde update_permissions_once.php olmalı (artisan ile aynı dizinde).
 * İşlem bittikten sonra bu dosyayı sunucudan silin.
 */

// İsteğe bağlı: .env'den key okuyamayız (Laravel yok henüz), sabit bir parola kullanın veya boş bırakın
$secret = ''; // Örn: 'gizli123' - doldurursanız ?key=gizli123 ile çağırın
if ($secret !== '' && (!isset($_GET['key']) || $_GET['key'] !== $secret)) {
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html><html><body><p>Yetkisiz. Doğru ?key= parametresi gerekli.</p></body></html>';
    exit;
}

$projectRoot = dirname(__DIR__);
$script = $projectRoot . DIRECTORY_SEPARATOR . 'update_permissions_once.php';

if (!is_file($script)) {
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html><html><body><p>update_permissions_once.php proje kökünde bulunamadı. Yol: ' . htmlspecialchars($script) . '</p></body></html>';
    exit;
}

header('Content-Type: text/html; charset=utf-8');
echo "<!DOCTYPE html><html><head><meta charset=\"utf-8\"><title>Yetkilendirme güncellemesi</title></head><body><pre>\n";

$phpBin = 'php';
if (getenv('PHP_CLI_PATH')) {
    $phpBin = getenv('PHP_CLI_PATH');
}
passthru($phpBin . ' ' . escapeshellarg($script));

echo "</pre><p><strong>İşlem bitti.</strong> Güvenlik için bu dosyayı (run-permissions-update.php) sunucudan silin.</p></body></html>";
