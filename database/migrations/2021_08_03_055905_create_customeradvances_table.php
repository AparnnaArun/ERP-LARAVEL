<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomeradvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customeradvances', function (Blueprint $table) {
           $table->id();
           $table->integer('slno')->nullable();
           $table->string('advanceno')->nullable();
            $table->decimal('advance',10,3)->default('0');
            $table->decimal('adv_out',10,3)->default('0');
            $table->decimal('bal_advnce',10,3)->default('0');
            $table->string('customer')->nullable();
            $table->date('dates')->nullable();
            $table->string('paymentmode')->nullable();
            $table->string('bankcash')->nullable();
            $table->string('chequeno')->nullable();
            $table->date('chequedate')->nullable();
            $table->string('from_where')->nullable();
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
        Schema::dropIfExists('customeradvances');
    }
}
