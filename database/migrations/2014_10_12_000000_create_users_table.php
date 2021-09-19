<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('login_name')->unique();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('usertype')->nullable();
            $table->string('manager')->nullable();
            $table->string('executive')->nullable();
            $table->string('costvisible')->nullable();
            $table->string('admin')->nullable();
            $table->string('accounts')->nullable();
            $table->string('inventory')->nullable();
            $table->string('hr')->nullable();
            $table->string('company')->nullable();
            $table->string('company2')->nullable();
            $table->string('divisiton')->nullable();
            $table->string('finyear')->nullable();
            $table->string('wdate')->nullable();
            $table->string('createdby')->nullable();
            $table->string('compid')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
