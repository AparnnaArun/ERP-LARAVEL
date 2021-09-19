<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegularvoucherentriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regularvoucherentries', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->nullable();
            $table->string('keycode')->nullable();
            $table->string('voucher')->nullable();
            $table->string('voucher_no')->nullable();
            $table->date('dates')->nullable();
            $table->decimal('totdebit',10,3)->default('0');
            $table->decimal('totcredit',10,3)->default('0');
            $table->string('created_datetime')->nullable();
            $table->string('created_by')->nullable();
            $table->string('froms')->nullable();
            $table->text('remarks')->nullable();
            $table->string('approved_by')->nullable();
            $table->enum('is_customeradnce',['0','1'])->default('0');
            $table->enum('is_vendoradnce',['0','1'])->default('0');
            $table->enum('optionalvoucher',['0','1'])->default('0');
            $table->string('from_where')->nullable();
            $table->string('regularized_by')->nullable();
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
        Schema::dropIfExists('regularvoucherentries');
    }
}
