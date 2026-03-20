<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('neighborhood')->nullable()->after('city_id');
            $table->string('street')->nullable()->after('neighborhood');
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('customer_neighborhood')->nullable()->after('customer_district');
            $table->string('customer_street')->nullable()->after('customer_neighborhood');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['neighborhood', 'street']);
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn(['customer_neighborhood', 'customer_street']);
        });
    }
};
