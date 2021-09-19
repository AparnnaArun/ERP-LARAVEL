<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarycalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salarycalculations', function (Blueprint $table) {
            $table->id();
            $table->integer('slid')->default('0');
            $table->string('name')->nullable();
            $table->decimal('bsalary', 10,3)->default('0');
            $table->decimal('allowance', 10,3)->default('0');
            $table->decimal('addallowance', 10,3)->default('0');
            $table->decimal('workingdays', 10,3)->default('0');
            $table->decimal('workeddays', 10,3)->default('0');
            $table->string('norover')->nullable();
            $table->string('frover')->nullable();
            $table->string('holover')->nullable();
            $table->decimal('nramount', 10,3)->default('0');
            $table->decimal('framount', 10,3)->default('0');
            $table->decimal('holamount', 10,3)->default('0');
            $table->decimal('thissalary',10,3)->default('0');
            $table->decimal('deduction',10,3)->default('0');
            $table->decimal('nettotal',10,3)->default('0');
            $table->decimal('advance',10,3)->default('0');
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
        Schema::dropIfExists('salarycalculations');
    }
}
