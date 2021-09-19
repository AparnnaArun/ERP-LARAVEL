<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crmforms', function (Blueprint $table) {
             $table->id();
            $table->date('dates')->nullable();
            $table->string('executive')->nullable();
            $table->string('customer')->nullable();
            $table->date('followupdate')->nullable();
            $table->text('feedback')->nullable();
            $table->enum('status',['0','1','2'])->default('0')->comment('open=0,closed=1,cancelled=2');
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
        Schema::dropIfExists('crmforms');
    }
}
