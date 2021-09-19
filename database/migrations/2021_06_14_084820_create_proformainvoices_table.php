<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformainvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proformainvoices', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->nullable();
            $table->string('pro_no')->nullable();
            $table->string('customer_ref')->nullable();
            $table->string('customer')->nullable();
            $table->string('authority')->nullable();
            $table->text('remarks')->nullable();
            $table->date('dates')->nullable();
            $table->decimal('total',10,3)->default('0');
            $table->decimal('discount_total',10,3)->default('0');
            $table->decimal('net_total',10,3)->default('0');
            $table->string('deli_info')->nullable();
            $table->string('paymentinfo')->nullable();
            $table->string('currency')->nullable();
            $table->string('designation')->nullable();
            
            $table->enum('paymentmode',['0','1'])->default('0');
            $table->enum('from_quote',['0','1'])->default('0');
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
        Schema::dropIfExists('proformainvoices');
    }
}
