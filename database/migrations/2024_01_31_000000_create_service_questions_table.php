<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('service_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id');
            $table->string('question');
            $table->string('type')->default('radio'); // radio, checkbox, select, text, number
            $table->boolean('is_required')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Foreign key to service_categories table (assuming id is integer based on context, if bigint change accordingly)
            // Checking ServiceCategory model implies it likely uses standard id.
        });

        Schema::create('service_question_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->string('option_text');
            $table->decimal('price_impact', 10, 2)->default(0.00);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('service_questions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_question_options');
        Schema::dropIfExists('service_questions');
    }
}
