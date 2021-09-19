<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningstockdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('openingstockdetails', function (Blueprint $table) {
       $table->id();
            $table->integer('opening_id')->nullable();
            $table->integer('item_id')->nullable();
           $table->date('inward_date')->nullable();
            $table->date('exp_date')->nullable();
            $table->string('batch')->nullable();
            $table->string('unit')->nullable();
              $table->decimal('opening_qnty',10,3)->default('0');
            $table->decimal('opening_rate',10,3)->default('0');
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
        Schema::dropIfExists('openingstockdetails');
    }
}
