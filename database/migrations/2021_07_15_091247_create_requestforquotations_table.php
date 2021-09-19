<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestforquotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requestforquotations', function (Blueprint $table) {
          $table->id();
            $table->integer('slno')->default('0');
            $table->string('req_no')->nullable();
            $table->date('dates')->nullable();
            $table->string('req_by')->nullable();
            $table->date('deliverydate')->nullable();
            $table->string('vendor')->nullable();
            $table->string('currency')->nullable();
            $table->string('projectcode')->nullable();
            $table->text('deliveryinfo')->nullable();
            $table->text('paymentterms')->nullable();
            $table->text('notes')->nullable();
            $table->string('req_from')->nullable();
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
        Schema::dropIfExists('requestforquotations');
    }
}
