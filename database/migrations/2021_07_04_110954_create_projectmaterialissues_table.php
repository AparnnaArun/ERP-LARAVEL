<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectmaterialissuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectmaterialissues', function (Blueprint $table) {
           $table->id();
            $table->integer('slno')->default('0');
            $table->string('issue_no')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('requisitionid')->nullable();
            $table->string('issue_from')->nullable();
            $table->date('dates')->nullable();
            $table->string('executive')->nullable();
             $table->integer('customer_id')->nullable();
            $table->string('customer')->nullable();
             $table->string('customerpo')->nullable();
            $table->decimal('total_amount',10,3)->default('0');
            $table->integer('commission_percentage')->default('0');
            $table->integer('comm_pay_account')->default('0');
            $table->integer('exe_com_exp_ac')->default('0');
         
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
        Schema::dropIfExists('projectmaterialissues');
    }
}
