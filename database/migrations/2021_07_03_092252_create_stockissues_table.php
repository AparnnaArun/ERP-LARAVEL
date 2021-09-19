<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockissuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockissues', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->default('0');
            $table->string('issue_no')->nullable();
            $table->date('issue_date')->nullable();
            $table->string('issue_to')->nullable();
            $table->string('issue_for')->nullable();
            $table->decimal('total_amount',10,3)->default('0');
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
        Schema::dropIfExists('stockissues');
    }
}
