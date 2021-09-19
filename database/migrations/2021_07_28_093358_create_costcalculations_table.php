<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostcalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costcalculations', function (Blueprint $table) {
           $table->id();
            $table->string('pi_no')->nullable();
            $table->decimal('purchasecost',10,3)->default('0');
            $table->decimal('addcharges',10,3)->default('0');
            $table->decimal('customs',10,3)->default('0');
            $table->decimal('freight',10,3)->default('0');
            $table->decimal('insurance',10,3)->default('0');
            $table->decimal('transport',10,3)->default('0');
            $table->decimal('extracost',10,3)->default('0');
            $table->decimal('totalextracost',10,3)->default('0');
            $table->decimal('percentextracost',10,3)->default('0');
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
        Schema::dropIfExists('costcalculations');
    }
}
