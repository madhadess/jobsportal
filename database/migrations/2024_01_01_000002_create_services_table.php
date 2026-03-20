<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('service_categories')->onDelete('cascade');
            $table->string('service_name');
            $table->string('service_slug')->unique();
            $table->text('service_desc');
            $table->string('service_image')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('price_model')->default('fixed'); // fixed, hourly, package
            $table->integer('duration_minutes')->nullable(); // Estimated duration in minutes
            $table->boolean('is_active')->default(1);
            $table->boolean('is_featured')->default(0);
            $table->integer('sort_order')->default(0);
            $table->integer('views_count')->default(0);
            $table->integer('requests_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
