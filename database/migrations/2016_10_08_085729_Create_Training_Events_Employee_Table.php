<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysTrainingEventsEmployeeTable extends Migration
{
    public function up()
    {
        Schema::create('sys_training_events_employee', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('training_id',11);
		$table->integer('emp_id',11);
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_training_events_employee');
    }
}