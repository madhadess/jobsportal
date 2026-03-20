<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');          // Hizmet alan (member)
            $table->string('title', 200);
            $table->enum('category_type', ['caregiver', 'service'])->default('service');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedInteger('state_id')->nullable(); // İl (FK → states)
            $table->unsignedInteger('city_id')->nullable();  // İlçe (FK → cities)
            $table->enum('work_type', ['full_time', 'part_time', 'daily'])->default('full_time');
            $table->time('work_hours_start')->nullable();
            $table->time('work_hours_end')->nullable();
            $table->tinyInteger('min_experience_years')->unsigned()->default(0);
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->boolean('requires_certificate')->default(false);
            $table->boolean('requires_reference')->default(false);
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'published', 'matched', 'closed', 'cancelled'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('matched_at')->nullable();
            $table->unsignedBigInteger('matched_user_id')->nullable(); // Kabul edilen aday
            $table->unsignedInteger('applications_count')->default(0); // Cache
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('matched_user_id')->references('id')->on('users')->onDelete('set null');
            $table->index(['status', 'category_type']);
            $table->index(['state_id', 'city_id']);
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_posts');
    }
};
