<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectexpenseentrydetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectexpenseentrydetails', function (Blueprint $table) {
            $table->id();
            $table->integer('expense_id')->nullable();
            $table->integer('projectid')->nullable();
            $table->string('projectcode')->nullable();
            $table->string('projectname')->nullable();
            $table->integer('customerid')->nullable();
            $table->string('customer')->nullable();
            $table->string('executive')->nullable();
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
        Schema::dropIfExists('projectexpenseentrydetails');
    }
}
