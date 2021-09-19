<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectinvoicedetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectinvoicedetails', function (Blueprint $table) {
           $table->id();
            $table->integer('proinv_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->string('item')->nullable();
            $table->decimal('rate',10,3)->default('0');
            $table->decimal('qnty',10,3)->default('0');
            $table->decimal('total',10,3)->default('0');
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
        Schema::dropIfExists('projectinvoicedetails');
    }
}
