<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostcalculationdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costcalculationdetails', function (Blueprint $table) {
             $table->id();
            $table->integer('costid')->nullable();
            $table->string('code')->nullable();
            $table->string('item')->nullable();
            $table->decimal('qnty',10,3)->default('0');
            $table->decimal('purcost',10,3)->default('0');
            $table->decimal('erate',10,3)->default('0');
            $table->decimal('kdamt',10,3)->default('0');
            $table->decimal('extracost',10,3)->default('0');
            $table->decimal('totalkd',10,3)->default('0');
            $table->decimal('totalextra',10,3)->default('0');
            $table->decimal('cost',10,3)->default('0');
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
        Schema::dropIfExists('costcalculationdetails');
    }
}
