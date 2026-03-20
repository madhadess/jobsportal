<?php
$rootDir = __DIR__;
$zipFile = $rootDir . '/project_bundle.zip';

$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    die("Cannot create zip file");
}

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootDir, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::LEAVES_ONLY
);

$excludeLocal = [
    '.git',
    'node_modules',
    'storage\\logs',
    'storage\\framework\\cache',
    'storage\\framework\\views',
    'storage\\framework\\sessions',
    'vendor', // User might want vendor included for shared hosting? 
    // "sunucuya yükleyeceğim" implies shared hosting often. 
    // But vendor is huge. 
    // Usually standard practice is to exclude vendor. 
    // BUT for "users" who ask "zip yap ver", they often don't run composer.
    // I will INCLUDE vendor but EXCLUDE .git and node_modules.
    'project_bundle.zip',
    'export_db.php',
    'reset_db.php',
    'zip_project.php',
    'append_css.php',
    'check_users.php'
];

// Re-evaluate vendor: 
// If I include vendor, it will be huge (100MB+).
// If user says "sunucuya yükleyeceğim", usually they need vendor.
// I will INCLUDE vendor.
// I WILL exclude node_modules.

foreach ($files as $name => $file) {
    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootDir) + 1);

        // Filters
        $shouldExclude = false;
        foreach ($excludeLocal as $exclude) {
            if (strpos($relativePath, $exclude) === 0 || strpos($relativePath, '\\' . $exclude) !== false || strpos($relativePath, '/' . $exclude) !== false) {
                // Check if it's strictly the folder or a child
                // Simple string check might be too aggressive (e.g. "vendor_stuff" vs "vendor/")
                // But for ".git" and "node_modules" it's fine.

                // Special check for exclusions that are directories
                if (in_array($exclude, ['.git', 'node_modules', 'storage\logs', 'storage\framework'])) {
                    $shouldExclude = true;
                    break;
                }
                // Exclude specific files
                if (basename($filePath) == $exclude) {
                    $shouldExclude = true;
                    break;
                }
            }
        }

        // Also exclude .env? No, user needs .env.example but maybe .env for their server?
        // Usually .env is excluded. But for "zip me up to upload", they might want it.
        // I will include .env but warn.

        if (!$shouldExclude) {
            $zip->addFile($filePath, $relativePath);
        }
    }
}

$zip->close();
echo "Zip created at $zipFile\n";
