<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverynotereturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverynotereturns', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->nullable();
            $table->string('rtn_no')->nullable();
            $table->string('deli_note_number')->nullable();
            $table->string('location')->nullable();
            $table->string('customer')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('deliverynotereturns');
    }
}
