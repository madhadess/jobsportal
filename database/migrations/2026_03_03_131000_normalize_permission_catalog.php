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

        $permissions = [
            'manage_definitions' => ['Tanım Yönetimi', 'Tanım modüllerini yönetme', 'settings'],
            'manage_roles' => ['Rol Yönetimi', 'Rolleri yönetme', 'admin'],
            'manage_admins' => ['Yönetici Yönetimi', 'Yönetici kullanıcıları yönetme', 'admin'],
            'manage_settings' => ['Ayarları Yönet', 'Site ayarlarını yönetme', 'admin'],
            'manage_security' => ['Güvenlik Ayarları', 'Güvenlik ayarlarını yönetme', 'admin'],
            'manage_campaigns' => ['Kampanya Yönetimi', 'E-posta kampanyalarını yönetme', 'admin'],
            'view_reports' => ['Raporları Görüntüle', 'Raporları görüntüleme', 'reports'],
            'export_reports' => ['Rapor Dışa Aktarma', 'Raporları dışa aktarma', 'reports'],
            'view_blog' => ['Blog Görüntüle', 'Blog içeriklerini görüntüleme', 'content'],
            'manage_blog' => ['Blog Yönetimi', 'Blog içeriklerini yönetme', 'content'],
            'view_orders' => ['Siparişleri Görüntüle', 'Ödeme/sipariş geçmişini görüntüleme', 'orders'],
            'view_service_categories' => ['Hizmet Kategorileri', 'Hizmet kategorilerini görüntüleme', 'services'],
            'view_service_addons' => ['Hizmet Eklentileri', 'Hizmet eklentilerini görüntüleme', 'services'],
            'view_caregivers' => ['Bakıcıları Görüntüle', 'Bakıcı listesini görüntüleme', 'caregivers'],
            'view_caregiver_categories' => ['Bakıcı Kategorileri', 'Bakıcı kategorilerini görüntüleme', 'caregivers'],
            'view_caregiver_requests' => ['Bakıcı Taleplerini Görüntüle', 'Bakıcı taleplerini görüntüleme', 'caregivers'],
            'view_crm' => ['CRM Görüntüle', 'CRM ekranlarını görüntüleme', 'crm'],
            'manage_crm' => ['CRM Yönetimi', 'CRM işlemlerini yönetme', 'crm'],
        ];

        $targetIds = [];
        foreach ($permissions as $name => [$displayName, $description, $group]) {
            $targetIds[$name] = $ensurePermission($name, $displayName, $description, $group);
        }

        $legacyToCanonical = [
            'reports.view' => 'view_reports',
            'reports.export' => 'export_reports',
            'admin.roles' => 'manage_roles',
            'admin.users' => 'manage_admins',
            'admin.settings' => 'manage_settings',
            'services.view' => 'view_services',
        ];

        foreach ($legacyToCanonical as $legacyName => $canonicalName) {
            $legacy = DB::table('permissions')->where('name', $legacyName)->first();
            if (!$legacy || !isset($targetIds[$canonicalName])) {
                continue;
            }

            $canonicalId = $targetIds[$canonicalName];
            if (Schema::hasTable('role_permissions')) {
                $roleIds = DB::table('role_permissions')->where('permission_id', $legacy->id)->pluck('role_id');
                foreach ($roleIds as $roleId) {
                    DB::table('role_permissions')->updateOrInsert(
                        ['role_id' => $roleId, 'permission_id' => $canonicalId],
                        ['created_at' => $now, 'updated_at' => $now]
                    );
                }
                DB::table('role_permissions')->where('permission_id', $legacy->id)->delete();
            }

            DB::table('permissions')->where('id', $legacy->id)->delete();
        }
    }

    public function down(): void
    {
        // Intentionally left empty to avoid destructive permission rollback.
    }
};
