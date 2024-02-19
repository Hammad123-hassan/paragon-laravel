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
           $table->string('applied_date')->nullable();
           $table->string('col_date')->nullable();
           $table->string('adventus_id')->nullable();
           $table->string('group_agent')->nullable();
           $table->string('full_fee')->nullable();
           $table->string('scholarship_discount')->nullable();
           $table->string('after_scholarship')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('applied_date');
            $table->dropColumn('col_date');
            $table->dropColumn('adventus_id');
            $table->dropColumn('group_agent');
            $table->dropColumn('full_fee');
            $table->dropColumn('scholarship_discount');
            $table->dropColumn('after_scholarship');
        });
    }
};
