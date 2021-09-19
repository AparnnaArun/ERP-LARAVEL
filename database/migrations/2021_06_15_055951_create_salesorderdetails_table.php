<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesorderdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesorderdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->integer('dnd_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->string('code')->nullable();
            $table->string('item')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('quantity',10,3)->default('0');
            $table->decimal('issdn_qnty',10,3)->default('0');
            $table->decimal('bal_qnty',10,3)->default('0');
            $table->decimal('rate',10,3)->default('0');
            $table->decimal('discount',10,3)->default('0');
            $table->decimal('amount',10,3)->default('0');
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
        Schema::dropIfExists('salesorderdetails');
    }
}
