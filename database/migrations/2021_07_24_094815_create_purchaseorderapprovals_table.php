<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseorderapprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseorderapprovals', function (Blueprint $table) {
            $table->id();

            $table->integer('slno')->default('0');
            $table->string('apprpo_no')->nullable();
            $table->string('po_no')->nullable();
            $table->string('odr_by')->nullable();
            $table->date('deli_date')->nullable();
            $table->string('vendor')->nullable();
            $table->string('reference')->nullable();
            $table->string('fob_point')->nullable();
            $table->string('order_validity')->nullable();
            $table->string('urgency_level')->nullable();
            $table->string('project_code')->nullable();
            $table->string('request_from')->nullable();
            $table->decimal('tot_qnty',10,3)->default('0');
            $table->decimal('tamount',10,3)->default('0');
            $table->decimal('discount_total',10,3)->default('0');
            $table->decimal('total',10,3)->default('0');
            $table->decimal('freight',10,3)->default('0');
            $table->decimal('pf',10,3)->default('0');
            $table->decimal('insurance',10,3)->default('0');
            $table->decimal('others',10,3)->default('0');
            $table->decimal('net_total',10,3)->default('0');
            $table->string('currency')->nullable();
            $table->text('remarks')->nullable();
            $table->text('deliveryinfo')->nullable();
            $table->text('paymentterms')->nullable();
            $table->text('shipping')->nullable();
            $table->string('order_date')->nullable();
            $table->enum('is_deleted',['0','1'])->default('0');
           
            $table->enum('is_grned',['0','1','2'])->default('0');
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
        Schema::dropIfExists('purchaseorderapprovals');
    }
}
