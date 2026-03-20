<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('match_rule_weights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rule_key', 50)->unique();        // 'location', 'category', etc.
            $table->string('rule_label', 100);              // Türkçe etiket
            $table->decimal('weight', 5, 2)->default(0);    // 0–100 arası
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('updated_by')->nullable(); // admin_id
            $table->timestamps();
        });

        // Seed default weights
        $now = now();
        DB::table('match_rule_weights')->insert([
            ['rule_key' => 'location', 'rule_label' => 'Lokasyon Uyumu', 'weight' => 20, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['rule_key' => 'category', 'rule_label' => 'Kategori Uyumu', 'weight' => 20, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['rule_key' => 'experience', 'rule_label' => 'Deneyim Yılı', 'weight' => 15, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['rule_key' => 'work_hours', 'rule_label' => 'Çalışma Saati Uyumu', 'weight' => 15, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['rule_key' => 'salary', 'rule_label' => 'Ücret Uyumu', 'weight' => 10, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['rule_key' => 'certificate', 'rule_label' => 'Sertifika Uyumu', 'weight' => 10, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['rule_key' => 'profile_completeness', 'rule_label' => 'Profil Tamlık Oranı', 'weight' => 10, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('match_rule_weights');
    }
};
