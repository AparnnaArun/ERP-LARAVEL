<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverynotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverynotes', function (Blueprint $table) {
          $table->id();
            $table->integer('slno')->nullable();
            $table->string('deli_note_no')->nullable();
            $table->string('so_no')->nullable();
            $table->string('customer')->nullable();
            $table->string('project_code')->nullable();
            $table->text('remarks')->nullable();
            $table->date('dates')->nullable();
            $table->text('cancelled_reason')->nullable();
            $table->string('manual_do')->nullable();
            $table->string('customer_po')->nullable();
            $table->enum('from_so',['0','1'])->default('0');
            $table->string('executive')->nullable();
            $table->decimal('total',10,3)->default('0');
            $table->enum('is_invoiced',['0','1','2'])->default('0');
            $table->enum('is_dortn',['0','1','2'])->default('0');
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
        Schema::dropIfExists('deliverynotes');
    }
}
