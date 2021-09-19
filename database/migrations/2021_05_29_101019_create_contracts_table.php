<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('empno')->nullable();
            $table->string('empname')->nullable();
            $table->string('position')->nullable();
            $table->date('dateofjoin')->nullable();
            $table->string('contractperiod')->nullable();
            $table->date('probperiodstart')->nullable();
            $table->date('probperiodend')->nullable();
            $table->string('probsalary')->nullable();
            $table->string('ticket')->nullable();
            $table->string('moballowance')->nullable();
            $table->string('vehicle')->nullable();
            $table->string('fuelallowance')->nullable();
            $table->string('accommodation')->nullable();
            $table->string('food')->nullable();
            $table->string('leavedetails')->nullable();
            $table->string('penality')->nullable();
            $table->string('confirmsalary')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
