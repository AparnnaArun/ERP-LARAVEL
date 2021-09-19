<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
           $table->id();
             $table->integer('slno')->default('0');
            $table->string('rept_no')->nullable();
            $table->integer('customer')->nullable();
            $table->decimal('advance',10,3)->default('0');
            $table->string('paymentmode')->nullable();
            $table->string('bank')->nullable();
            $table->date('dates')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->decimal('roundoff',10,3)->default('0');
            $table->decimal('totaladvace',10,3)->default('0');
            $table->decimal('total',10,3)->default('0');
            $table->text('remarks')->nullable();
            $table->decimal('nettotal',10,3)->default('0');
            $table->decimal('totalamount',10,3)->default('0');
            $table->date('bank_date')->nullable();
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
        Schema::dropIfExists('receipts');
    }
}
