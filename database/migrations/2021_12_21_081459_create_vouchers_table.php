<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable()->comment('1=bankPayment&2=bankReceipt&3=CashPayment,4=CashReceipt');
            $table->integer('campus_id');
            $table->string('voucher_no');

            $table->string('memo')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('active')->default(0);
            $table->date('voucher_date');
            $table->integer('challan_id')->default()->nullable();
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
        Schema::dropIfExists('vouchers');
    }
}
