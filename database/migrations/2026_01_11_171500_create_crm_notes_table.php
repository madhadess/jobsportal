<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('crm_notes')) {
            Schema::create('crm_notes', function (Blueprint $row) {
                $row->id();
                $row->unsignedBigInteger('admin_id')->comment('The staff member the note is about');
                $row->unsignedBigInteger('creator_id')->comment('The admin who created the note');
                $row->string('title');
                $row->text('content');
                $row->dateTime('event_date')->nullable();
                $row->boolean('is_completed')->default(false);
                $row->string('priority')->default('Medium')->comment('Low, Medium, High');
                $row->timestamps();

                // Foreign keys if necessary, assuming admins table exists
                if (Schema::hasTable('admins')) {
                    $row->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
                    $row->foreign('creator_id')->references('id')->on('admins')->onDelete('cascade');
                }
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('crm_notes');
    }
};
