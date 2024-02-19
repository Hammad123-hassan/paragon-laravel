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
        Schema::create('visa_decisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_case_id');
            $table->string('status')->nullable();

            $table->string('date_of_decision');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_decisions');
    }
};
