<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePreRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_registers', function (Blueprint $table) {
            $table->increments('id');
            $table->date('expected_date');
            $table->time('expected_time');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedInteger('visitor_id')->unsigned();
            $table->string('comment')->nullable();
            $table->auditColumn();
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
        Schema::drop('pre_registers');
    }
}
