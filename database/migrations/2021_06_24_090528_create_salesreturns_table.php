<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesreturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesreturns', function (Blueprint $table) {
           $table->id();
            $table->integer('slno')->nullable();
            $table->string('rtndate')->nullable();
            $table->string('rtn_no')->nullable();
            $table->string('location')->nullable();
            $table->string('salesid')->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('currency')->nullable();
            $table->string('executive')->nullable();
            $table->date('salesdate')->nullable();
            $table->string('payment_mode')->nullable();
            $table->decimal('discount_total',10,3)->default('0');
             $table->decimal('erate',10,3)->default('0');
              $table->decimal('total',10,3)->default('0');
               $table->decimal('totcosts',10,3)->default('0');
                $table->decimal('tax',10,3)->default('0');
                 $table->decimal('freight',10,3)->default('0');
                  $table->decimal('pf',10,3)->default('0');
                   $table->decimal('insurance',10,3)->default('0');
                    $table->decimal('others',10,3)->default('0');
                    $table->decimal('roundoff',10,3)->default('0');
                    $table->decimal('net_total',10,3)->default('0');
                    $table->string('vehicle_details')->nullable();
                    $table->text('deli_info')->nullable();
                    $table->text('payment_terms')->nullable();
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
        Schema::dropIfExists('salesreturns');
    }
}
