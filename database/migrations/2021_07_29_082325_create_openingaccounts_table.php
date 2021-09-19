<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningaccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('openingaccounts', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule')->nullable();
            $table->decimal('diffopenbal',10,3)->default('0');
            $table->decimal('totdebit',10,3)->default('0');
            $table->decimal('totcredit',10,3)->default('0');
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
        Schema::dropIfExists('openingaccounts');
    }
}
