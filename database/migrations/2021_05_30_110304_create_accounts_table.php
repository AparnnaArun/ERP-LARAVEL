<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
             $table->string('accounttype')->nullable();
            $table->string('seqnumber')->nullable();
             $table->enum('active',['0','1'])->nullable();
            $table->string('name')->nullable();
            $table->string('printname')->nullable();
            $table->integer('parentid')->default('0');
           
            $table->string('description')->nullable();
            $table->string('category')->nullable();
            $table->string('fullcode')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
