<?php
// debug_permissions.php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Role;
use App\Models\Permission;

echo "<pre>";
echo "<h1>Permission Debugger</h1>";

echo "<h2>All Defined Permissions (DB)</h2>";
$permissions = Permission::all();
foreach ($permissions as $p) {
    echo "ID: {$p->id} | Name: <b>{$p->name}</b> | Display: {$p->display_name}<br>";
}

echo "<hr>";

echo "<h2>Roles and Assigned Permissions</h2>";
$roles = Role::with('permissions')->get();
foreach ($roles as $role) {
    echo "<h3>Role: {$role->role_name} (ID: {$role->id})</h3>";
    echo "Active: " . ($role->is_active ? 'YES' : 'NO') . "<br>";
    echo "System: " . ($role->is_system ? 'YES' : 'NO') . "<br>";
    echo "<b>Permissions:</b><br>";
    if ($role->permissions->count() > 0) {
        foreach ($role->permissions as $p) {
            echo "- {$p->name} ({$p->display_name})<br>";
        }
    } else {
        echo "<i>No permissions assigned.</i><br>";
    }
    echo "<br>";
}

echo "</pre>";
