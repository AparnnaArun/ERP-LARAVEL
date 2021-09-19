<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesreturndetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesreturndetails', function (Blueprint $table) {
            $table->id();
            $table->integer('rtn_id')->nullable();
            $table->string('return_no')->nullable();
            $table->integer('item_id')->nullable();
            
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->string('unit')->nullable();
            $table->string('batch')->nullable();
            $table->decimal('rate',10,3)->default('0');
            $table->decimal('salesquantity',10,3)->default('0');
            $table->decimal('freeqnty',10,3)->default('0');
             $table->decimal('rtnqnty',10,3)->default('0');
             $table->decimal('damage',10,3)->default('0');
             $table->decimal('rtnfreeqnty',10,3)->default('0');
            $table->decimal('discount',10,3)->default('0');
            $table->decimal('amount',10,3)->default('0');
            $table->decimal('totalcost',10,3)->default('0');
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
        Schema::dropIfExists('salesreturndetails');
    }
}
