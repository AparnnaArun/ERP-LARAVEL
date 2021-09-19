<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarycalculationmainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salarycalculationmains', function (Blueprint $table) {
            $table->id();
            $table->integer('slno')->nullable();
            $table->date('dates')->nullable();
            $table->string('keycode')->nullable();
            $table->string('voucher')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->decimal('workingdays', 10,3)->default('0');
            $table->decimal('totalnetsalary',10,3)->default('0');
            $table->decimal('totaladvance',10,3)->default('0');
            $table->decimal('collected_amount',10,3)->default('0');
            $table->decimal('balance',10,3)->default('0');
            $table->decimal('collectedadvnce',10,3)->default('0');
            $table->decimal('advncebalnce',10,3)->default('0');
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
        Schema::dropIfExists('salarycalculationmains');
    }
}
