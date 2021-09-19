<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
             $table->integer('slno')->nullable();
            $table->string('empid')->unique();
            $table->string('name')->nullable();
            $table->string('dob')->nullable();
            $table->string('dateofjoining')->nullable();
            $table->string('joiningposition')->nullable();
            $table->string('department')->nullable();
            $table->string('curposition')->nullable();
            $table->string('salaried')->nullable();
            $table->string('approve')->nullable();
            $table->string('bsalary')->nullable();
            $table->string('allowance')->nullable();
            $table->string('vehicleno')->nullable();
            $table->string('accname')->nullable();
            $table->text('address')->nullable();
            $table->string('actualdob')->nullable();
            $table->text('homeaddr')->nullable();
            $table->string('kwttel1')->nullable();
            $table->string('kwttel2')->nullable();
            $table->string('hometel')->nullable();
            $table->string('email')->nullable();
            $table->string('emergency1')->nullable();
            $table->string('emergency1no')->nullable();
            $table->string('emergency2')->nullable();
            $table->string('emergency2no')->nullable();
            $table->string('spouse')->nullable();
            $table->string('spouseno')->nullable();
            $table->string('nochildren')->nullable();
            $table->string('education')->nullable();
            $table->string('passportno')->nullable();
            $table->date('passportexp')->nullable();
            $table->string('civilidno')->nullable();
            $table->date('civilidexp')->nullable();
            $table->string('lisenceno')->nullable();
            $table->date('lisenceexp')->nullable();
            $table->string('weddate')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
