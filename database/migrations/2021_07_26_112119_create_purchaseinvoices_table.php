<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseinvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseinvoices', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->default('0');
            $table->string('p_invoice')->nullable();
            $table->string('invoice')->nullable();
            $table->date('dates')->nullable();
            $table->string('vendor')->nullable();
            $table->string('payment_mode')->nullable();
            $table->date('inv_date')->nullable();
            $table->string('project_code')->nullable();
            $table->string('purchase_method')->nullable();
            $table->string('currency')->nullable();
            $table->string('locations')->nullable();
            $table->string('grnid')->nullable();
            $table->decimal('additionalcharges',10,3)->default('0');
            $table->decimal('tot_qnty',10,3)->default('0');
            $table->decimal('tamount',10,3)->default('0');
            $table->decimal('discount_total',10,3)->default('0');
            $table->decimal('tax',10,3)->default('0');
            $table->decimal('net_total',10,3)->default('0');
            $table->decimal('erate',10,3)->default('0');
            $table->decimal('totalamount',10,3)->default('0');
            $table->decimal('collected_amount',10,3)->default('0');
            $table->decimal('debit_note_amount',10,3)->default('0');
            $table->decimal('balance',10,3)->default('0');
            $table->enum('is_deleted',['0','1'])->default('0');
            $table->enum('is_returned',['0','1','2'])->default('0');
            $table->enum('paidstatus',['0','1','2'])->default('0');
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
        Schema::dropIfExists('purchaseinvoices');
    }
}
