<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesettlementdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expensesettlementdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('sttlid')->nullable();
            $table->integer('purchaseid')->nullable();
            $table->integer('vendor')->nullable();
            $table->string('invoiceno')->nullable();
            $table->date('dates')->nullable();
            $table->decimal('grandtotal',10,3)->default('0');
            $table->decimal('collected',10,3)->default('0');
            $table->decimal('balance',10,3)->default('0');
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
        Schema::dropIfExists('expensesettlementdetails');
    }
}
