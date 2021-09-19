<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectmaterialrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectmaterialrequests', function (Blueprint $table) {
           $table->id();
            $table->integer('slno')->default('0');
            $table->string('matreq_no')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('req_by')->nullable();
            $table->date('req_date')->nullable();
            $table->text('purpose')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('customer')->nullable();
            $table->string('customerpo')->nullable();
            $table->string('executive')->nullable();
            $table->enum('status',['0','1','2'])->default('0');
            $table->decimal('net_total',10,3)->default('0');
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
        Schema::dropIfExists('projectmaterialrequests');
    }
}
