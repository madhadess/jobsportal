<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('listing_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_post_id');
            $table->unsignedBigInteger('user_id');               // Başvuran personel/bakıcı
            $table->text('cover_note')->nullable();               // Kısa başvuru notu
            $table->enum('status', [
                'pending',
                'shortlisted',
                'invited',
                'accepted',
                'rejected',
                'withdrawn'
            ])->default('pending');
            $table->decimal('match_score', 5, 2)->nullable();     // 0-100 uygunluk skoru
            $table->json('match_breakdown')->nullable();           // Kriter bazlı puanlar
            $table->text('match_explanation')->nullable();         // Türkçe açıklama
            $table->boolean('is_auto_matched')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('job_post_id')->references('id')->on('job_posts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['job_post_id', 'user_id']);           // Çift başvuru engeli
            $table->index(['status', 'job_post_id']);
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('listing_applications');
    }
};
