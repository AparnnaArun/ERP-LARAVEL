<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expensesettlements', function (Blueprint $table) {
             $table->id();
             $table->integer('slno')->default('0');
            $table->string('settle_no')->nullable();
            $table->string('paymentmode')->nullable();
            $table->string('bank')->nullable();
            $table->date('dates')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('bank_name')->nullable();
            // $table->decimal('roundoff',10,3)->default('0');
            // $table->decimal('totaladvace',10,3)->default('0');
            $table->enum('settle_type',['1','2','3','4'])->nullable()->comment('1=ProSalary,2=ProCommission,3=StaffSalary,4=BankCharge');
            $table->text('remarks')->nullable();
            $table->decimal('nettotal',10,3)->default('0');
            // $table->decimal('totalamount',10,3)->default('0');
            $table->date('bank_date')->nullable();
            // $table->decimal('erate',10,3)->default('0');
            // $table->string('currency')->nullable();
            $table->enum('is_deleted',['0','1'])->default('0');
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
        Schema::dropIfExists('expensesettlements');
    }
}
