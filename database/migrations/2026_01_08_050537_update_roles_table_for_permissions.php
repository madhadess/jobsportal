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
        Schema::table('roles', function (Blueprint $table) {
            // Yeni alanlar ekle
            $table->string('display_name', 100)->nullable()->after('role_name');
            $table->text('description')->nullable()->after('display_name');
            $table->boolean('is_active')->default(true)->after('description');
            $table->boolean('is_system')->default(false)->after('is_active'); // Sistem rolleri silinemez
            $table->timestamp('created_by')->unsigned()->nullable()->after('is_system');
        });

        // Varsayılan rolleri ekle
        DB::table('roles')->insert([
            [
                'role_name' => 'SUPER_ADMIN',
                'display_name' => 'Süper Yönetici',
                'description' => 'Sistemin tüm yetkilerine sahip en üst düzey yönetici',
                'is_active' => true,
                'is_system' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'ADMIN',
                'display_name' => 'Yönetici',
                'description' => 'Genel yönetici yetkilerine sahip kullanıcı',
                'is_active' => true,
                'is_system' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'MODERATOR',
                'display_name' => 'Moderatör',
                'description' => 'İçerik yönetimi ve temel yetkilere sahip kullanıcı',
                'is_active' => true,
                'is_system' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['display_name', 'description', 'is_active', 'is_system', 'created_by']);
        });
    }
};
