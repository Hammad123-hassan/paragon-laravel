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
        Schema::table('leads', function (Blueprint $table) {
            $table->string('consultancy_fee')->nullable();
            $table->string('consultancy_fee_mark_date')->nullable();
            $table->string('university_fee_mark_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('consultancy_fee');
            $table->dropColumn('consultancy_fee_mark_date');
            $table->dropColumn('university_fee_mark_date');
        });
    }
};
