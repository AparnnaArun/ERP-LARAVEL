<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecutiveoverheadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('executiveoverheads', function (Blueprint $table) {
          $table->id();
            $table->integer('slno')->default('0');
            $table->string('ovr_no')->nullable();
            $table->string('overhead_type')->nullable();
            $table->string('invoice_no')->nullable();
            $table->date('dates')->nullable();
            $table->string('executive')->nullable();
            $table->decimal('amount',10,3)->default('0');
            $table->string('paymentmode')->nullable();
            $table->string('bank')->nullable();
            $table->string('chequeno')->nullable();
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
        Schema::dropIfExists('executiveoverheads');
    }
}
