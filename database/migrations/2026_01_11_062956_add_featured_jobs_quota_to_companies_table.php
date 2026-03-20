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
        Schema::table('companies', function (Blueprint $table) {
            $table->integer('featured_jobs_quota')->default(0)->after('availed_cvs_quota');
            $table->integer('availed_featured_jobs_quota')->default(0)->after('featured_jobs_quota');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('featured_jobs_quota');
            $table->dropColumn('availed_featured_jobs_quota');
        });
    }
};
