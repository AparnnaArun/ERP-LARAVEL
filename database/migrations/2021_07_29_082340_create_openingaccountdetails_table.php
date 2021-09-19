<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningaccountdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('openingaccountdetails', function (Blueprint $table) {
             $table->id();
             $table->integer('opaccid')->nullable();
             $table->integer('acchead')->nullable();
             $table->string('accname')->nullable();
             $table->decimal('debit',10,3)->default('0');
             $table->decimal('credit',10,3)->default('0');
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
        Schema::dropIfExists('openingaccountdetails');
    }
}
