<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaserequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaserequisitions', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->default('0');
            $table->string('req_no')->nullable();
            $table->date('dates')->nullable();
            $table->string('req_by')->nullable();
             $table->date('deliverydate')->nullable();
            $table->string('vendor')->nullable();
            $table->string('reqdept')->nullable();
            $table->text('remarks')->nullable();
            $table->string('projectcode')->nullable();
            $table->string('deliveryaddr')->nullable();
            $table->string('req_from')->nullable();
            $table->enum('is_deleted',['0','1'])->default('0');
            $table->enum('is_returned',['0','1','2'])->default('0');
            $table->string('createdby')->nullable();
            $table->string('finyear')->nullable();
            $table->string('wdate')->nullable();
            $table->string('cmpid')->nullable();
            $table->timestamps();
            $table->string('approvedby')->nullable();
            $table->date('approveddate')->nullable();
            $table->enum('approvalstatus',['0','1'])->default('0');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchaserequisitions');
    }
}
