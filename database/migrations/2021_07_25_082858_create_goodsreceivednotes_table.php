<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsreceivednotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goodsreceivednotes', function (Blueprint $table) {
             $table->id();

            $table->integer('slno')->default('0');
            $table->string('grn_no')->nullable();
            $table->integer('po_no')->nullable();
            $table->string('dc')->nullable();
            $table->date('dc_date')->nullable();
            $table->string('vendor')->nullable();
            $table->string('project_code')->nullable();
            $table->string('locations')->nullable();
            $table->decimal('tot_qnty',10,3)->default('0');
            $table->date('dates')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('is_deleted',['0','1'])->default('0');
            $table->enum('is_invoiced',['0','1','2'])->default('0');
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
        Schema::dropIfExists('goodsreceivednotes');
    }
}
