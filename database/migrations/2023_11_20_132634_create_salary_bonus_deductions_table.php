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
        Schema::create('salary_bonus_deductions', function (Blueprint $table) {
            $table->id();
            $table->integer('salary_bonus_deduction_id');
            $table->integer('user_id');
            $table->string('deduction')->nullable()->default(0);
            $table->string('bonus')->nullable()->default(0);
            $table->string('paid_mark')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_bonus_deductions');
    }
};
