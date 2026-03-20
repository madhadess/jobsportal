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
        Schema::table('users', function (Blueprint $table) {
            // Personnel Automation Fields
            $table->json('service_types')->nullable()->after('verified'); // List of service IDs they can perform
            $table->json('work_locations')->nullable()->after('service_types'); // List of districts/cities
            $table->json('availability_calendar')->nullable()->after('work_locations'); // Availability logic
            $table->decimal('average_rating', 3, 2)->default(0.00)->after('availability_calendar');
            $table->integer('max_daily_tasks')->default(1)->after('average_rating');
            $table->integer('current_active_tasks')->default(0)->after('max_daily_tasks');
            $table->timestamp('last_task_date')->nullable()->after('current_active_tasks');
            $table->boolean('is_eligible_for_auto_assignment')->default(true)->after('last_task_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'service_types',
                'work_locations',
                'availability_calendar',
                'average_rating',
                'max_daily_tasks',
                'current_active_tasks',
                'last_task_date',
                'is_eligible_for_auto_assignment'
            ]);
        });
    }
};
