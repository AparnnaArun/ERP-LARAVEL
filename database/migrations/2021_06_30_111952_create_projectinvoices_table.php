<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectinvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectinvoices', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->nullable();
            $table->string('projinv_no')->nullable();
            $table->integer('projectid')->nullable();
            $table->string('projectname')->nullable();
            $table->integer('customerid')->nullable();
            $table->string('customer')->nullable();
            $table->date('dates')->nullable();
            $table->decimal('totalamount',10,3)->default('0');
            $table->decimal('collected_amount',10,3)->default('0');
            $table->decimal('creditnote_amount',10,3)->default('0');
            $table->decimal('bal_amount',10,3)->default('0');
            $table->enum('paidstatus',['0','1','2'])->default('0');
            $table->string('executive')->nullable();
            $table->enum('is_deleted',['0','1'])->default('0');
            $table->integer('commission_percentage')->nullable();
            $table->integer('comm_pay_account')->nullable();
            $table->integer('exe_com_exp_ac')->nullable();
            $table->integer('cus_accnt')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('projectinvoices');
    }
}
