<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesenquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesenquiries', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->default('0');
            $table->string('enq_no')->nullable();
            $table->string('enq_ref')->nullable();
            $table->string('customer')->nullable();
            $table->string('executive')->nullable();
            $table->string('authority')->nullable();
            $table->string('designation')->nullable();
            $table->string('remarks')->nullable();
            $table->date('dates')->nullable();
            $table->decimal('net_total',10,3)->default('0');
            $table->string('deli_info')->nullable();
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
        Schema::dropIfExists('salesenquiries');
    }
}
