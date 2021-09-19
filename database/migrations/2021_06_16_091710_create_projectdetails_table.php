<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->nullable();
            $table->string('project_code')->nullable();
            $table->string('project_name')->nullable();
            $table->string('short_name')->nullable();
            $table->enum('active',['0','1'])->default('0');
            $table->integer('customer_id')->nullable();
            $table->date('exp_startingdate')->nullable();
            $table->date('exp_endingdate')->nullable();
            $table->string('executive')->nullable();
            $table->string('customer_po')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('is_completed',['0','1'])->default('0');
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
        Schema::dropIfExists('projectdetails');
    }
}
