<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class ExportDatabase extends Command
{
    protected $signature = 'db:export {--output= : SQL dosya yolu (varsayılan: storage/app/backup) }';
    protected $description = 'Mevcut veritabanından güncel SQL dump alır ve projeye ekler.';

    public function handle(): int
    {
        $connection = config('database.default');
        $config = config("database.connections.{$connection}");

        if (($config['driver'] ?? '') !== 'mysql') {
            $this->error('Sadece MySQL/MariaDB desteklenir.');
            return self::FAILURE;
        }

        $host = $config['host'] ?? '127.0.0.1';
        $port = $config['port'] ?? 3306;
        $database = $config['database'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';

        if (empty($database) || empty($username)) {
            $this->error('.env içinde DB_DATABASE ve DB_USERNAME tanımlı olmalı.');
            return self::FAILURE;
        }

        $mysqldump = $this->findMysqldump();
        if (!$mysqldump) {
            $this->error('mysqldump bulunamadı. Windows için .env içine MYSQLDUMP_PATH ekleyin (örn: C:\wamp64\bin\mysql\mysql8.4.7\bin\mysqldump.exe)');
            return self::FAILURE;
        }

        $dir = $this->option('output') ? dirname($this->option('output')) : storage_path('app/backup');
        $filename = $this->option('output') ? basename($this->option('output')) : $database . '_guncel_' . date('Y-m-d_His') . '.sql';
        $path = $dir . DIRECTORY_SEPARATOR . $filename;

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $cmd = sprintf(
            '%s -h %s -P %s -u %s %s --single-transaction --routines --triggers --no-tablespaces 2>&1',
            escapeshellarg($mysqldump),
            escapeshellarg($host),
            (int) $port,
            escapeshellarg($username),
            escapeshellarg($database)
        );

        $this->info('Dump alınıyor: ' . $database . ' -> ' . $path);
        if ($password !== '') {
            putenv('MYSQL_PWD=' . $password);
        }
        $output = [];
        exec($cmd, $output, $exitCode);
        if ($password !== '') {
            putenv('MYSQL_PWD');
        }
        $content = implode("\n", $output);

        if ($exitCode !== 0 && strpos($content, 'Access denied') !== false) {
            $this->error('Veritabanı erişim hatası. .env içindeki DB bilgilerini kontrol edin.');
            return self::FAILURE;
        }

        if ($exitCode !== 0) {
            $this->error('mysqldump hatası: ' . $content);
            return self::FAILURE;
        }

        file_put_contents($path, $content);
        $this->info('SQL dump kaydedildi: ' . $path);
        return self::SUCCESS;
    }

    private function findMysqldump(): ?string
    {
        $envPath = env('MYSQLDUMP_PATH');
        if ($envPath && is_executable($envPath)) {
            return $envPath;
        }
        if ($envPath && file_exists($envPath)) {
            return $envPath;
        }

        $try = ['mysqldump', 'mysqldump.exe'];
        foreach ($try as $bin) {
            $found = trim((string) shell_exec('which ' . escapeshellarg($bin) . ' 2>/dev/null'));
            if ($found !== '' && file_exists($found)) {
                return $found;
            }
        }

        if (PHP_OS_FAMILY === 'Windows') {
            $wamp = 'C:\\wamp64\\bin\\mysql\\mysql8.4.7\\bin\\mysqldump.exe';
            if (file_exists($wamp)) {
                return $wamp;
            }
            $glob = glob('C:\\wamp64\\bin\\mysql\\*\\bin\\mysqldump.exe');
            if (!empty($glob)) {
                return $glob[0];
            }
        }

        return null;
    }
}
