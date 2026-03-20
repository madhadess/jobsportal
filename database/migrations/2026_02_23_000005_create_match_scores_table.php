<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('match_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_post_id');
            $table->unsignedBigInteger('user_id');               // Personel/Bakıcı id
            $table->decimal('total_score', 5, 2);                // 0–100 arası
            $table->json('breakdown');                           // Kriter bazlı detaylar
            $table->text('explanation')->nullable();             // Türkçe açıklama
            $table->string('engine_version', 20)->default('v1'); // Uyumluluk için
            $table->timestamp('computed_at')->useCurrent();
            $table->timestamps();

            $table->foreign('job_post_id')->references('id')->on('job_posts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['job_post_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('match_scores');
    }
};
