<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockadjustmentdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockadjustmentdetails', function (Blueprint $table) {
           $table->id();
             $table->integer('stockid')->nullable();
             $table->integer('item_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item')->nullable();
            $table->string('unit')->nullable();
            $table->string('batch')->nullable();
            $table->decimal('qnty',10,3)->default('0');
           $table->decimal('rate',10,3)->default('0');
            $table->decimal('stock_value',10,3)->default('0');
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
        Schema::dropIfExists('stockadjustmentdetails');
    }
}
