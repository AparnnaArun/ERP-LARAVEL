<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendoradvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendoradvances', function (Blueprint $table) {
             $table->id();
             $table->integer('slno')->nullable();
             $table->string('advanceno')->nullable();
            $table->decimal('advance',10,3)->default('0');
            $table->decimal('adv_taken',10,3)->default('0');
            $table->decimal('bal_advnce',10,3)->default('0');
            $table->string('vendor')->nullable();
            $table->date('dates')->nullable();
            $table->string('paymentmode')->nullable();
            $table->string('bankcash')->nullable();
            $table->string('chequeno')->nullable();
            $table->date('chequedate')->nullable();
             $table->string('from_where')->nullable();
             $table->decimal('erate',10,3)->default('0');
            $table->string('currency')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('vendoradvances');
    }
}
