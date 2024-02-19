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
        Schema::create('cas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_case_id');
            $table->string('cas_request')->nullable();
            $table->string('cas_receive')->nullable();
            $table->string('request_date')->nullable();
            $table->string('receive_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cas');
    }
};
