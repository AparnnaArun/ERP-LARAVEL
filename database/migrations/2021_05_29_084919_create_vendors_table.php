<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
             $table->string('vendor')->nullable();
            $table->enum('active',['0','1'])->nullable();
            $table->string('short_name')->nullable();
            $table->string('account')->nullable();
            $table->enum('approve',['0','1'])->nullable();
            $table->string('address')->nullable();
            $table->string('business_type')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('lead_time')->nullable();
            $table->string('email')->nullable();
            $table->string('tax_applicable')->nullable();
            $table->string('credit_limit')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('credit_days')->nullable();
            $table->string('tax_exempted')->nullable();
            $table->string('exciseduty_applicable')->nullable();
            
            $table->string('designation')->nullable();
            $table->string('contract_date')->nullable();
            $table->string('security_deposit')->nullable();
            $table->string('termsand_conditions')->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
