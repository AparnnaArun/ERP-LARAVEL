<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockissuereturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockissuereturns', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->default('0');
            $table->string('issuertn_no')->nullable();
            $table->string('stockissueno')->nullable();
            $table->date('issuertn_date')->nullable();
             $table->string('issuertn_from')->nullable();
            $table->string('return_type')->nullable();
            $table->integer('location')->nullable();
            $table->text('remarks')->nullable();
            $table->decimal('total_amount',10,3)->default('0');
            $table->enum('is_deleted',['0','1'])->default('0');
            $table->enum('is_returned',['0','1','2'])->default('0');
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
        Schema::dropIfExists('stockissuereturns');
    }
}
