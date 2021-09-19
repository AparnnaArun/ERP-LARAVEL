<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectmaterialrequestdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectmaterialrequestdetails', function (Blueprint $table) {
            $table->id();
             $table->integer('matreq_id')->nullable();
             $table->integer('item_id')->nullable();
            $table->string('code')->nullable();
            $table->string('item_name')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('req_qnty',10,3)->default('0');
            $table->decimal('iss_qnty',10,3)->default('0');
            $table->decimal('bal_qnty',10,3)->default('0');
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
        Schema::dropIfExists('projectmaterialrequestdetails');
    }
}
