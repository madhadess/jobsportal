<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('paytr_merchant_id')->nullable()->after('accountnumber_jobg8');
            $table->string('paytr_merchant_key')->nullable()->after('paytr_merchant_id');
            $table->string('paytr_merchant_salt')->nullable()->after('paytr_merchant_key');
            $table->tinyInteger('is_paytr_active')->default(0)->after('paytr_merchant_salt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['paytr_merchant_id', 'paytr_merchant_key', 'paytr_merchant_salt', 'is_paytr_active']);
        });
    }
};
