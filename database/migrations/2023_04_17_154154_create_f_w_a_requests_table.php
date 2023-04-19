<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('f_w_a_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_id');
            $table->string('request_date');
            $table->string('work_type');
            $table->string('description');
            $table->string('reason');
            $table->string('status');
            $table->string('comment')->nullable()->default(NULL);
            $table->foreignId('employee_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f_w_a_requests');
    }
};
