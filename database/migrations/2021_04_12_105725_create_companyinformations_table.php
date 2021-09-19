<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyinformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companyinformations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->text('address');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('email')->unique();
            $table->string('active')->nullable();
            $table->string('trading')->nullable();
            $table->string('manufacturing')->nullable();
            $table->string('admin')->nullable();
            $table->string('inventory')->nullable();
            $table->string('accounts')->nullable();
            $table->string('hr')->nullable();
            $table->string('createdby');
            $table->string('compid');
            $table->string('finyear');
            $table->string('wdate');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companyinformations');
    }
}
