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
        Schema::table('service_requests', function (Blueprint $table) {
            $table->enum('automation_status', ['pending_matching', 'matched', 'failed', 'admin_review'])
                ->default('pending_matching')
                ->after('status');

            $table->unsignedBigInteger('matched_personnel_id')->nullable()->after('automation_status');
            $table->integer('matching_attempts')->default(0)->after('matched_personnel_id');

            // Additional details for smarter matching
            $table->integer('service_duration')->default(2)->after('matching_attempts'); // Estimated hours
            $table->string('home_size')->nullable()->after('service_duration'); // e.g., 3+1, 120m2

            // Foreign key for matched personnel
            $table->foreign('matched_personnel_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign(['matched_personnel_id']);
            $table->dropColumn([
                'automation_status',
                'matched_personnel_id',
                'matching_attempts',
                'service_duration',
                'home_size'
            ]);
        });
    }
};
