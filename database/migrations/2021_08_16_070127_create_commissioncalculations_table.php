<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissioncalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissioncalculations', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->nullable();
            $table->string('enrty_no')->nullable();
            $table->date('dates')->nullable();
            $table->string('executive')->nullable();
            $table->decimal('total_income',10,3)->default('0');
            $table->decimal('total_expense',10,3)->default('0');
            $table->decimal('profit',10,3)->default('0');
            $table->decimal('commission_payable',10,3)->default('0');
            $table->decimal('commission_paid',10,3)->default('0');
            $table->decimal('balance',10,3)->default('0');
            $table->decimal('paycommission',10,3)->default('0');
            $table->string('paymentmode')->nullable();
            $table->string('bankcash')->nullable();
            $table->string('chequeno')->nullable();
            $table->date('chequedate')->nullable();
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
        Schema::dropIfExists('commissioncalculations');
    }
}
