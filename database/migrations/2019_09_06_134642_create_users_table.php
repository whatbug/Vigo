<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('run_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('run_user')->default(0);
            $table->string('max_value',10)->default(5);
            $table->string('run_value',10)->default(0);
            $table->string('mobile',15)->default(0);
            $table->string('run_time',10)->default(0);
            $table->integer('run_type')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('run_data');
    }
}
