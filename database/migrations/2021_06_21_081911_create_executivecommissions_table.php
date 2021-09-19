<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecutivecommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('executivecommissions', function (Blueprint $table) {
            $table->id();
            $table->integer('inv_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('customer')->nullable();
            $table->string('executive')->nullable();
            $table->decimal('percent',10,3)->default('0');
            $table->decimal('total_amount',10,3)->default('0');
            $table->decimal('net_total',10,3)->default('0');
            $table->decimal('profit',10,3)->default('0');
            $table->decimal('profitpay',10,3)->default('0');
            $table->decimal('totcost',10,3)->default('0');
            $table->decimal('paid_amount',10,3)->default('0');
            $table->string('from_where')->nullable();
            $table->enum('is_deleted',['1','0'])->default('0');
            $table->date('dates')->nullable();
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
        Schema::dropIfExists('executivecommissions');
    }
}
