<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysLeaveTypeTable extends Migration
{
    public function up()
    {
        Schema::create('sys_leave_type', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->string('leave',100);
		$table->integer('leave_quota',11);
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_leave_type');
    }
}