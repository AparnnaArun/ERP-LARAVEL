<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockissuedetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockissuedetails', function (Blueprint $table) {
          $table->id();
             $table->integer('stockissue_id')->nullable();
             $table->integer('item_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->string('unit')->nullable();
            $table->string('batch')->nullable();
            $table->decimal('issue_qnty',10,3)->default('0');
            $table->decimal('rtn_qnty',10,3)->default('0');
            $table->decimal('pen_qnty',10,3)->default('0');
            $table->decimal('rate',10,3)->default('0');
            $table->decimal('stockissue_value',10,3)->default('0');
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
        Schema::dropIfExists('stockissuedetails');
    }
}
