<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesinvoicedetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesinvoicedetails', function (Blueprint $table) {
            $table->id();
            $table->integer('inv_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('delidetid')->nullable();
            $table->integer('item_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->string('unit')->nullable();
            $table->string('batch')->nullable();
            $table->decimal('rate',10,3)->default('0');
            $table->decimal('quantity',10,3)->default('0');
            $table->decimal('amount',10,3)->default('0');
            $table->decimal('discount',10,3)->default('0');
            $table->decimal('freeqnty',10,3)->default('0');
            $table->decimal('totalcost',10,3)->default('0');
            $table->decimal('isslnrtn_qnty',10,3)->default('0');
            $table->decimal('penrtn_qnty',10,3)->default('0');
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
        Schema::dropIfExists('salesinvoicedetails');
    }
}
