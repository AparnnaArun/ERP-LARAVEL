<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectexpenseentriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectexpenseentries', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->nullable();
            $table->string('entry_no')->nullable();
            $table->string('keycode')->nullable();
            $table->string('executive')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->integer('projectid')->nullable();

            $table->string('expense_type')->nullable();
            $table->text('remarks')->nullable();
            $table->date('dates')->nullable();
            $table->string('user')->nullable();
            $table->string('paymentmode')->nullable();
            $table->string('bankcash')->nullable();
            $table->decimal('totalamount',10,3)->default('0');
            $table->string('number')->nullable();
            $table->string('bank')->nullable();
            $table->decimal('totalamt',10,3)->default('0');
            $table->decimal('collected_amount',10,3)->default('0');
            $table->decimal('debitnote_amount',10,3)->default('0');
            $table->decimal('balance_amount',10,3)->default('0');
            $table->enum('paidstatus',['0','1','2'])->default('0');
            $table->decimal('balanceamount',10,3)->default('0');
             $table->enum('expensefrom',['0','1','2'])->default('0');
            $table->enum('is_deleted',['0','1'])->default('0');
            $table->integer('commission_percentage')->nullable();
            $table->integer('comm_pay_account')->nullable();
            $table->integer('exe_com_exp_ac')->nullable();
            $table->string('createdby')->nullable();
            $table->string('finyear')->nullable();
            $table->string('wdate')->nullable();
            $table->string('cmpid')->nullable();
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
        Schema::dropIfExists('projectexpenseentries');
    }
}
