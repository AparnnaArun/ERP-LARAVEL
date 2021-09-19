<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesinvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesinvoices', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('po_number')->nullable();
            $table->string('manual_do_no')->nullable();
            $table->string('manual_inv_no')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('cus_accnt')->nullable();
            $table->string('customer')->nullable();
            $table->string('payment_mode')->nullable();
            $table->date('dates')->nullable();
            $table->decimal('total',10,3)->default('0');
            $table->string('currency')->nullable();
            $table->string('deli_note_no')->nullable();
            $table->string('ship_to')->nullable();
            $table->enum('invoicefrom',['0','1'])->default('0');
            $table->string('delinoteno')->nullable();
            $table->decimal('discount_total',10,3)->default('0');
            $table->decimal('net_total',10,3)->default('0');
            $table->decimal('freight',10,3)->default('0');
            $table->decimal('pf',10,3)->default('0');
            $table->decimal('insurance',10,3)->default('0');
            $table->decimal('others',10,3)->default('0');
            $table->decimal('advance',10,3)->default('0');
            $table->decimal('grand_total',10,3)->default('0');
            $table->decimal('collected_amount',10,3)->default('0');
            $table->decimal('creditnote_amount',10,3)->default('0');
            $table->decimal('balance',10,3)->default('0');
            $table->text('deli_info')->nullable();
            $table->text('payment_terms')->nullable();
            $table->text('vehicle_details')->nullable();
            $table->decimal('tax',10,3)->default('0');
            $table->decimal('sales_commission',10,3)->default('0');
            $table->decimal('erate',10,3)->default('0');
            $table->enum('paidstatus',['0','1','2'])->default('0');
            $table->decimal('totcosts',10,3)->default('0');
            $table->decimal('isslnrtn_amt',10,3)->default('0');
            $table->decimal('rtncost',10,3)->default('0');
            $table->decimal('profit',10,3)->default('0');
            $table->integer('commission_percentage')->nullable();
            $table->integer('comm_pay_account')->nullable();
            $table->integer('exe_com_exp_ac')->nullable();
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
        Schema::dropIfExists('salesinvoices');
    }
}
