<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vehicleno')->unique();
            $table->string('vehicletype')->nullable();
            $table->string('manufactyear')->nullable();
            $table->date('purchasedate')->nullable();
            $table->decimal('purchaseamount', 10,3)->nullable();
            $table->date('registrationexpiry')->nullable();
            $table->string('insurance')->nullable();
            $table->date('insuranceexpiry')->nullable();
            $table->string('salesdate')->nullable();
            $table->enum('active',['0','1'])->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
