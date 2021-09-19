<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('account')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->string('address')->nullable();
            $table->enum('active',['0','1'])->nullable();
            $table->enum('approve',['0','1'])->nullable();
            $table->enum('specialprice',['0','1'])->default('0');
            $table->string('businesstype')->nullable();
            $table->string('ratetype')->nullable();
            $table->string('creditlimit')->nullable();
            $table->string('creditdays')->nullable();
            $table->string('taxapplicable')->nullable();
            $table->string('website')->nullable();
            $table->string('taxexempted')->nullable();
            $table->string('customerstatus')->nullable();
            $table->string('contactperson')->nullable();
            $table->string('designation')->nullable();
            $table->string('cpersonphone')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
