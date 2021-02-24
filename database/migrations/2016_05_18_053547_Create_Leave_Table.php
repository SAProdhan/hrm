<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysLeaveTable extends Migration
{
    public function up()
    {
        Schema::create('sys_leave', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('emp_id',11);
		$table->date('leave_from');
		$table->date('leave_to');
		$table->integer('ltype_id',11);
		$table->date('applied_on');
		$table->string('leave_reason',100)->nullable()->default('NULL');
		$table->enum('status',['approved','pending','rejected'])->default('pending');
		$table->text('remark');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_leave');
    }
}