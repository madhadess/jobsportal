<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('permissions')) {
            return;
        }

        $now = now();

        $ensurePermission = function (string $name, string $displayName, string $description, string $group) use ($now): int {
            $existing = DB::table('permissions')->where('name', $name)->first();
            if ($existing) {
                DB::table('permissions')->where('id', $existing->id)->update([
                    'display_name' => $displayName,
                    'description' => $description,
                    'group' => $group,
                    'is_active' => 1,
                    'updated_at' => $now,
                ]);
                return (int) $existing->id;
            }

            return (int) DB::table('permissions')->insertGetId([
                'name' => $name,
                'display_name' => $displayName,
                'description' => $description,
                'group' => $group,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        };

        $canonical = [
            'view_service_requests' => ['Hizmet Taleplerini Görüntüle', 'Hizmet taleplerini görüntüleme', 'service_requests'],
            'manage_service_requests' => ['Hizmet Talebi Yönetimi', 'Hizmet taleplerini yönetme', 'service_requests'],
            'approve_service_requests' => ['Hizmet Talebi Onaylama', 'Hizmet taleplerini onaylama', 'service_requests'],
            'manage_service_request_status' => ['Hizmet Talebi Durumu', 'Hizmet talebi durumunu güncelleme', 'service_requests'],
        ];

        $targetIds = [];
        foreach ($canonical as $name => [$display, $desc, $group]) {
            $targetIds[$name] = $ensurePermission($name, $display, $desc, $group);
        }

        $legacyToCanonical = [
            'service_requests.view' => 'view_service_requests',
            'service_requests.edit' => 'manage_service_requests',
            'service_requests.delete' => 'manage_service_requests',
            'edit_service_requests' => 'manage_service_requests',
            'delete_service_requests' => 'manage_service_requests',
        ];

        foreach ($legacyToCanonical as $legacyName => $canonicalName) {
            $legacy = DB::table('permissions')->where('name', $legacyName)->first();
            if (!$legacy) {
                continue;
            }

            $canonicalId = $targetIds[$canonicalName];

            if (Schema::hasTable('role_permissions')) {
                $roleIds = DB::table('role_permissions')
                    ->where('permission_id', $legacy->id)
                    ->pluck('role_id');

                foreach ($roleIds as $roleId) {
                    DB::table('role_permissions')->updateOrInsert(
                        ['role_id' => $roleId, 'permission_id' => $canonicalId],
                        ['updated_at' => $now, 'created_at' => $now]
                    );
                }

                DB::table('role_permissions')->where('permission_id', $legacy->id)->delete();
            }

            DB::table('permissions')->where('id', $legacy->id)->delete();
        }
    }

    public function down(): void
    {
        // No down action to avoid destructive permission rollback.
    }
};
