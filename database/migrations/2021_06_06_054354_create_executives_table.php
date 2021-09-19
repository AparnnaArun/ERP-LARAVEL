<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecutivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('executives', function (Blueprint $table) {
            $table->id();
            $table->string('executive')->nullable();
            $table->string('short_name')->nullable();
            $table->integer('account')->nullable();
            $table->integer('comm_pay_account')->nullable();
            $table->integer('exe_com_exp_ac')->nullable();
            $table->enum('active',['0','1'])->default('0');
            $table->enum('is_commissioned',['0','1'])->default('0');
            $table->integer('commission_percentage')->default('0');
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
        Schema::dropIfExists('executives');
    }
}
