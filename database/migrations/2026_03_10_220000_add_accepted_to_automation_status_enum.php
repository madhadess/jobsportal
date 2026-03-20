<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddAcceptedToAutomationStatusEnum extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE service_requests MODIFY COLUMN automation_status ENUM('pending_matching', 'matched', 'failed', 'admin_review', 'accepted') NULL DEFAULT NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE service_requests MODIFY COLUMN automation_status ENUM('pending_matching', 'matched', 'failed', 'admin_review') NULL DEFAULT NULL");
    }
}
