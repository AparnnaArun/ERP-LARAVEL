<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegularvoucherentrydetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regularvoucherentrydetails', function (Blueprint $table) {
          $table->id();
            $table->integer('voucherid')->nullable();
            $table->string('debitcredit')->nullable();
            $table->integer('account_name')->nullable();
            $table->text('narration')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('cheque_bank')->nullable();
            $table->string('cheque_clearance')->nullable();
            $table->decimal('amount',10,3)->default('0');
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
        Schema::dropIfExists('regularvoucherentrydetails');
    }
}
