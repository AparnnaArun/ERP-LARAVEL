<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesorders', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->nullable();
            $table->string('order_no')->nullable();
            $table->string('reference')->nullable();
            $table->string('customer')->nullable();
            $table->string('fob_point')->nullable();
            $table->text('ship_to')->nullable();
            $table->date('dates')->nullable();
            $table->date('purodr_date')->nullable();
            $table->string('currency')->nullable();
            $table->enum('order_from',['0','1'])->default('0');
            $table->decimal('total',10,3)->default('0');
            $table->decimal('discount_total',10,3)->default('0');
            $table->decimal('net_total',10,3)->default('0');
            $table->decimal('erate',10,3)->default('0');
            $table->decimal('tax',10,3)->default('0');
            $table->decimal('freight',10,3)->default('0');
            $table->decimal('insurance',10,3)->default('0');
            $table->decimal('others',10,3)->default('0');
            $table->decimal('pf',10,3)->default('0');
            $table->text('deli_info')->nullable();
            $table->text('payment_terms')->nullable();
            $table->text('dispatch_details')->nullable();
            $table->text('remarks')->nullable();
            $table->string('approved_by')->nullable();
            $table->enum('is_deleted',['0','1'])->default('0');
            $table->enum('call_for_do',['0','1','2'])->default('0');
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
        Schema::dropIfExists('salesorders');
    }
}
