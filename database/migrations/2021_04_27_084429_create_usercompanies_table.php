<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsercompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usercompanies', function (Blueprint $table) {
            $table->id();
            $table->integer('userid');
            $table->integer('companyid');
           $table->string('createdby')->nullable();
            $table->string('compid')->nullable();
            $table->string('finyear')->nullable();
            $table->string('wdate')->nullable();
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
        Schema::dropIfExists('usercompanies');
    }
}
