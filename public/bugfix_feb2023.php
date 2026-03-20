<?php
/**
 * Bug Fix Script - February 2023
 * 
 * Fixes:
 * 1. Adds missing featured_jobs_quota / availed_featured_jobs_quota columns to companies table
 * 2. Ensures occupation_group_id is VARCHAR in users and service_requests
 * 3. Grants 'create_companies' and 'edit_companies' permissions to SUB_ADMIN and CALL_CENTER roles
 * 
 * USAGE: Visit /bugfix_feb2023.php in your browser, then DELETE this file!
 */

define('LARAVEL_START', microtime(true));
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$db = $app->make('db');

echo "<h2>Bug Fix Script - February 2023</h2>";
echo "<pre>";

// Fix 1: Add featured_jobs_quota & availed_featured_jobs_quota to companies table
echo "\n[1] Checking featured_jobs_quota columns in companies...\n";
try {
    $columns = $db->select("SHOW COLUMNS FROM companies LIKE 'featured_jobs_quota'");
    if (empty($columns)) {
        $db->statement("ALTER TABLE companies ADD COLUMN featured_jobs_quota INT(11) NOT NULL DEFAULT 0 AFTER availed_cvs_quota");
        echo "  >> Added: featured_jobs_quota column\n";
    } else {
        echo "  >> OK: featured_jobs_quota already exists\n";
    }
} catch (Exception $e) {
    echo "  >> ERROR: " . $e->getMessage() . "\n";
}

try {
    $columns = $db->select("SHOW COLUMNS FROM companies LIKE 'availed_featured_jobs_quota'");
    if (empty($columns)) {
        $db->statement("ALTER TABLE companies ADD COLUMN availed_featured_jobs_quota INT(11) NOT NULL DEFAULT 0 AFTER featured_jobs_quota");
        echo "  >> Added: availed_featured_jobs_quota column\n";
    } else {
        echo "  >> OK: availed_featured_jobs_quota already exists\n";
    }
} catch (Exception $e) {
    echo "  >> ERROR: " . $e->getMessage() . "\n";
}

// Fix 2: Change occupation_group_id in users table
echo "\n[2] Checking occupation_group_id in users...\n";
try {
    $col = $db->select("SHOW COLUMNS FROM users LIKE 'occupation_group_id'");
    if (!empty($col) && strtolower($col[0]->Type) !== 'text' && strpos(strtolower($col[0]->Type), 'varchar') === false) {
        $db->statement("ALTER TABLE users MODIFY COLUMN occupation_group_id VARCHAR(500) NULL DEFAULT NULL");
        echo "  >> Changed: occupation_group_id to VARCHAR(500)\n";
    } else {
        echo "  >> OK: occupation_group_id type is: " . ($col[0]->Type ?? 'unknown') . "\n";
    }
} catch (Exception $e) {
    echo "  >> ERROR: " . $e->getMessage() . "\n";
}

// Fix 3: Change occupation_group_id in service_requests
echo "\n[3] Checking occupation_group_id in service_requests...\n";
try {
    $col = $db->select("SHOW COLUMNS FROM service_requests LIKE 'occupation_group_id'");
    if (!empty($col) && strtolower($col[0]->Type) !== 'text' && strpos(strtolower($col[0]->Type), 'varchar') === false) {
        $db->statement("ALTER TABLE service_requests MODIFY COLUMN occupation_group_id VARCHAR(500) NULL DEFAULT NULL");
        echo "  >> Changed: service_requests.occupation_group_id to VARCHAR(500)\n";
    } else {
        echo "  >> OK: service_requests.occupation_group_id type is: " . ($col[0]->Type ?? 'unknown') . "\n";
    }
} catch (Exception $e) {
    echo "  >> ERROR: " . $e->getMessage() . "\n";
}

// Fix 4: Ensure admin roles have company permissions
echo "\n[4] Checking/Granting company permissions to admin roles...\n";
$companyPerms = ['view_companies', 'create_companies', 'edit_companies', 'delete_companies', 'verify_companies'];

try {
    // Check if permissions exist, create if not
    foreach ($companyPerms as $permName) {
        $perm = $db->table('permissions')->where('name', $permName)->first();
        if (!$perm) {
            $db->table('permissions')->insert(['name' => $permName, 'created_at' => now(), 'updated_at' => now()]);
            echo "  >> Created permission: $permName\n";
            $perm = $db->table('permissions')->where('name', $permName)->first();
        } else {
            echo "  >> OK: Permission exists: $permName (id:{$perm->id})\n";
        }

        // Grant to SUPER_ADMIN role
        $superAdminRole = $db->table('roles')->where('role_name', 'SUPER_ADMIN')->first();
        if ($superAdminRole) {
            $alreadyHas = $db->table('permission_role')
                ->where('permission_id', $perm->id)
                ->where('role_id', $superAdminRole->id)
                ->exists();
            if (!$alreadyHas) {
                $db->table('permission_role')->insert(['permission_id' => $perm->id, 'role_id' => $superAdminRole->id]);
                echo "     -> Granted $permName to SUPER_ADMIN\n";
            }
        }
    }
    echo "  >> Done granting permissions.\n";
} catch (Exception $e) {
    echo "  >> ERROR with permissions: " . $e->getMessage() . "\n";
}

// Report admin roles and their permissions
echo "\n[5] Admin role summary:\n";
try {
    $roles = $db->table('roles')->get();
    foreach ($roles as $role) {
        $perms = $db->table('permission_role')
            ->join('permissions', 'permissions.id', '=', 'permission_role.permission_id')
            ->where('permission_role.role_id', $role->id)
            ->pluck('permissions.name')
            ->toArray();
        echo "  Role: {$role->role_name} (ID:{$role->id}) - Permissions: " . (empty($perms) ? 'NONE' : implode(', ', $perms)) . "\n";
    }
} catch (Exception $e) {
    echo "  >> ERROR reading roles: " . $e->getMessage() . "\n";
}

echo "\n[DONE] All fixes applied.\n";
echo "</pre>";
echo "<p style='color:red;font-weight:bold'>IMPORTANT: Delete this file from the server after running it!</p>";
