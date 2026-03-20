<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('job_post_requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_post_id');
            $table->string('requirement_type', 50); // e.g., 'certificate', 'language', 'skill', 'document'
            $table->string('requirement_value', 200);
            $table->boolean('is_mandatory')->default(false);
            $table->timestamps();

            $table->foreign('job_post_id')->references('id')->on('job_posts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_post_requirements');
    }
};
