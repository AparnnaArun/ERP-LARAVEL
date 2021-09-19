<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesenquirydetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesenquirydetails', function (Blueprint $table) {
            $table->id();
             $table->integer('enq_id')->nullable();
             $table->string('code')->nullable();
            $table->integer('item_id')->nullable();
            $table->string('item_name')->nullable();
            $table->string('unit')->nullable();
            $table->string('description')->nullable();
            $table->decimal('quantity',10,3)->default('0');
            $table->string('squoteqnty',10,3)->nullable();
            $table->string('balqnty',10,3)->nullable();
            $table->string('drawing_no')->nullable();
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
        Schema::dropIfExists('salesenquirydetails');
    }
}
