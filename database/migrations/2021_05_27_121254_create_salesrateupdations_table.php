<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesrateupdationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesrateupdations', function (Blueprint $table) {
            $table->id();
             $table->date('date')->nullable();
              $table->string('division')->nullable();
               $table->string('category')->nullable();
                $table->integer('item_id')->nullable();
                 $table->string('item')->nullable();
                  $table->string('batch')->nullable();
                  $table->decimal('retail_salesrate', 10,3)->nullable();
                  $table->decimal('retail_bottomrate', 10,3)->nullable();
                  $table->decimal('wholesale_salesrate', 10,3)->nullable();
                  $table->decimal('wholesale_bottomrate', 10,3)->nullable();
                  $table->decimal('dealer_salesrate', 10,3)->nullable();
                  $table->decimal('dealer_bottomrate', 10,3)->nullable();
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
        Schema::dropIfExists('salesrateupdations');
    }
}
