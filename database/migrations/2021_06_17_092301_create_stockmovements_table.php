<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockmovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockmovements', function (Blueprint $table) {
            $table->id();
            $table->integer('voucher_id')->nullable();
            $table->string('voucher_type')->nullable();
            $table->date('voucher_date')->nullable();
            $table->string('description')->nullable();
            $table->string('location_id')->nullable();
            $table->string('item_id')->nullable();
             $table->string('unit')->nullable();
            $table->string('batch')->nullable();
            $table->decimal('rate',10,3)->default('0');
            $table->decimal('quantity',10,3)->default('0');
            $table->decimal('stock_value',10,3)->default('0');
            $table->decimal('qntyout',10,3)->default('0');
            $table->decimal('stockout',10,3)->default('0');
           $table->string('status')->nullable();
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
        Schema::dropIfExists('stockmovements');
    }
}
