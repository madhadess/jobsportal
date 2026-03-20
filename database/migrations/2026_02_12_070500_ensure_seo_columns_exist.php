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
        Schema::table('seo', function (Blueprint $table) {
            if (!Schema::hasColumn('seo', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('page_title');
            }
            if (!Schema::hasColumn('seo', 'route_name')) {
                $table->string('route_name')->nullable()->unique()->after('slug');
            }
            if (!Schema::hasColumn('seo', 'controller_action')) {
                $table->string('controller_action')->nullable()->after('route_name');
            }
            if (!Schema::hasColumn('seo', 'is_static')) {
                $table->boolean('is_static')->default(0)->after('controller_action');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('seo', function (Blueprint $table) {
            if (Schema::hasColumn('seo', 'is_static')) {
                $table->dropColumn('is_static');
            }
            if (Schema::hasColumn('seo', 'controller_action')) {
                $table->dropColumn('controller_action');
            }
            if (Schema::hasColumn('seo', 'route_name')) {
                $table->dropColumn('route_name');
            }
            if (Schema::hasColumn('seo', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};
