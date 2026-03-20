<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('application_status_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->string('status_from', 20)->nullable();
            $table->string('status_to', 20);
            $table->text('comment')->nullable();
            $table->string('changed_by', 50)->default('system'); // 'member', 'personnel', 'admin', 'system'
            $table->unsignedBigInteger('changed_by_id')->nullable();
            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('listing_applications')->onDelete('cascade');
            $table->index('application_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('application_status_history');
    }
};
