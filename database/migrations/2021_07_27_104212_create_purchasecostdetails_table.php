<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasecostdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasecostdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('pcid')->default(0);
            $table->string('pinvid')->default(0);
            $table->string('addnos')->nullable();
            $table->date('dates')->nullable();
            $table->string('costfor')->nullable();
            $table->string('vendoracc')->nullable();
            $table->string('vendor')->nullable();
            $table->decimal('amount',10,3)->default('0');
            $table->decimal('settledamt',10,3)->default('0');
            $table->decimal('unsettledamt',10,3)->default('0');
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
        Schema::dropIfExists('purchasecostdetails');
    }
}
