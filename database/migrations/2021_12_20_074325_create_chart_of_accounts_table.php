<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_chart_of_account_id')->default(0)->nullable();
            $table->integer('main_chart_of_account_id')->default(0)->nullable();
            $table->string('title');
            $table->string('code');
            $table->string('account_number');
            $table->integer('level');
            $table->string('account_type')->default('normal');
            $table->boolean('active')->default(true);
            $table->integer('debit')->default(0);
            $table->integer('credit')->default(0);
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
        Schema::dropIfExists('chart_of_accounts');
    }
}
