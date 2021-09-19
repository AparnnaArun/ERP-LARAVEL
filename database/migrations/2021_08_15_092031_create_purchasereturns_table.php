<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasereturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasereturns', function (Blueprint $table) {
           $table->id();
            $table->integer('slno')->default('0');
            $table->string('prtn')->nullable();
            $table->date('dates')->nullable();
            $table->string('vendor')->nullable();
            $table->string('project_code')->nullable();
            $table->string('currency')->nullable();
            $table->string('pi_no')->nullable();
            $table->decimal('discount_total',10,3)->default('0');
            $table->decimal('tot_qnty',10,3)->default('0');
            $table->decimal('tamount',10,3)->default('0');
            $table->decimal('nettotal',10,3)->default('0');
            $table->decimal('erate',10,3)->default('0');
            $table->decimal('totalamount',10,3)->default('0');
            $table->enum('is_deleted',['0','1'])->default('0');
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
        Schema::dropIfExists('purchasereturns');
    }
}
