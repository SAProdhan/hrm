<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeetodevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeetodevices', function (Blueprint $table) {
            $table->unsignedInteger('employee_id');
            $table->unsignedBigInteger('device_id');
            $table->integer('uid');           
            $table->foreign('employee_id')->references('id')->on('sys_employee')->onDelete('cascade');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employeetodevices');
    }
}
