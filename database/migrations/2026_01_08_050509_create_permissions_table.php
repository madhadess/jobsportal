<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique(); // İzin adı (örn: users.create)
            $table->string('display_name', 100); // Görünen ad (örn: Kullanıcı Oluştur)
            $table->string('description', 255)->nullable(); // Açıklama
            $table->string('group', 50); // Grup (örn: users, companies, reports)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // İndeksler
            $table->index('name');
            $table->index('group');
            $table->index('is_active');
        });

        // Varsayılan izinleri ekle
        $permissions = [
            // Kullanıcı yönetimi
            ['name' => 'users.view', 'display_name' => 'Kullanıcıları Görüntüle', 'description' => 'Kullanıcı listesini görüntüleme yetkisi', 'group' => 'users'],
            ['name' => 'users.create', 'display_name' => 'Kullanıcı Oluştur', 'description' => 'Yeni kullanıcı oluşturma yetkisi', 'group' => 'users'],
            ['name' => 'users.edit', 'display_name' => 'Kullanıcı Düzenle', 'description' => 'Kullanıcı bilgilerini düzenleme yetkisi', 'group' => 'users'],
            ['name' => 'users.delete', 'display_name' => 'Kullanıcı Sil', 'description' => 'Kullanıcı silme yetkisi', 'group' => 'users'],
            
            // Şirket yönetimi
            ['name' => 'companies.view', 'display_name' => 'Şirketleri Görüntüle', 'description' => 'Şirket listesini görüntüleme yetkisi', 'group' => 'companies'],
            ['name' => 'companies.create', 'display_name' => 'Şirket Oluştur', 'description' => 'Yeni şirket oluşturma yetkisi', 'group' => 'companies'],
            ['name' => 'companies.edit', 'display_name' => 'Şirket Düzenle', 'description' => 'Şirket bilgilerini düzenleme yetkisi', 'group' => 'companies'],
            ['name' => 'companies.delete', 'display_name' => 'Şirket Sil', 'description' => 'Şirket silme yetkisi', 'group' => 'companies'],
            ['name' => 'companies.verify', 'display_name' => 'Şirket Doğrula', 'description' => 'Şirket doğrulama yetkisi', 'group' => 'companies'],
            
            // İş ilanları yönetimi
            ['name' => 'jobs.view', 'display_name' => 'İş İlanlarını Görüntüle', 'description' => 'İş ilanlarını görüntüleme yetkisi', 'group' => 'jobs'],
            ['name' => 'jobs.create', 'display_name' => 'İş İlanı Oluştur', 'description' => 'Yeni iş ilanı oluşturma yetkisi', 'group' => 'jobs'],
            ['name' => 'jobs.edit', 'display_name' => 'İş İlanı Düzenle', 'description' => 'İş ilanı bilgilerini düzenleme yetkisi', 'group' => 'jobs'],
            ['name' => 'jobs.delete', 'display_name' => 'İş İlanı Sil', 'description' => 'İş ilanı silme yetkisi', 'group' => 'jobs'],
            ['name' => 'jobs.feature', 'display_name' => 'İş İlanı Öne Çıkar', 'description' => 'İş ilanını öne çıkarma yetkisi', 'group' => 'jobs'],
            ['name' => 'jobs.approve', 'display_name' => 'İş İlanı Onayla', 'description' => 'İş ilanını onaylama yetkisi', 'group' => 'jobs'],
            
            // Başvurular yönetimi
            ['name' => 'applications.view', 'display_name' => 'Başvuruları Görüntüle', 'description' => 'İş başvurularını görüntüleme yetkisi', 'group' => 'applications'],
            ['name' => 'applications.edit', 'display_name' => 'Başvuru Durumu Düzenle', 'description' => 'Başuru durumunu düzenleme yetkisi', 'group' => 'applications'],
            ['name' => 'applications.delete', 'display_name' => 'Başvuru Sil', 'description' => 'Başvuru silme yetkisi', 'group' => 'applications'],
            
            // Raporlama
            ['name' => 'reports.view', 'display_name' => 'Raporları Görüntüle', 'description' => 'Raporları görüntüleme yetkisi', 'group' => 'reports'],
            ['name' => 'reports.export', 'display_name' => 'Raporları İndir', 'description' => 'Raporları indirme yetkisi', 'group' => 'reports'],
            
            // Hizmetler
            ['name' => 'services.view', 'display_name' => 'Hizmetleri Görüntüle', 'description' => 'Hizmetleri görüntüleme yetkisi', 'group' => 'services'],
            ['name' => 'services.create', 'display_name' => 'Hizmet Oluştur', 'description' => 'Yeni hizmet oluşturma yetkisi', 'group' => 'services'],
            ['name' => 'services.edit', 'display_name' => 'Hizmet Düzenle', 'description' => 'Hizmet bilgilerini düzenleme yetkisi', 'group' => 'services'],
            ['name' => 'services.delete', 'display_name' => 'Hizmet Sil', 'description' => 'Hizmet silme yetkisi', 'group' => 'services'],
            
            // Hizmet talepleri
            ['name' => 'service_requests.view', 'display_name' => 'Hizmet Taleplerini Görüntüle', 'description' => 'Hizmet taleplerini görüntüleme yetkisi', 'group' => 'service_requests'],
            ['name' => 'service_requests.edit', 'display_name' => 'Hizmet Talebi Düzenle', 'description' => 'Hizmet talebini düzenleme yetkisi', 'group' => 'service_requests'],
            ['name' => 'service_requests.delete', 'display_name' => 'Hizmet Talebi Sil', 'description' => 'Hizmet talebini silme yetkisi', 'group' => 'service_requests'],
            
            // Yönetim paneli
            ['name' => 'admin.users', 'display_name' => 'Admin Kullanıcıları Yönet', 'description' => 'Admin kullanıcılarını yönetme yetkisi', 'group' => 'admin'],
            ['name' => 'admin.roles', 'display_name' => 'Rolleri Yönet', 'description' => 'Rolleri yönetme yetkisi', 'group' => 'admin'],
            ['name' => 'admin.permissions', 'display_name' => 'İzinleri Yönet', 'description' => 'İzinleri yönetme yetkisi', 'group' => 'admin'],
            ['name' => 'admin.settings', 'display_name' => 'Ayarları Yönet', 'description' => 'Site ayarlarını yönetme yetkisi', 'group' => 'admin'],
            ['name' => 'admin.reports', 'display_name' => 'Admin Raporları', 'description' => 'Admin raporlarını görüntüleme yetkisi', 'group' => 'admin'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'name' => $permission['name'],
                'display_name' => $permission['display_name'],
                'description' => $permission['description'],
                'group' => $permission['group'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
