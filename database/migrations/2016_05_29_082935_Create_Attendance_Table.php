<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysAttendanceTable extends Migration
{
    public function up()
    {
        Schema::create('sys_attendance', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('emp_id',11);
		$table->integer('designation',11);
		$table->integer('department',11);
		$table->string('date',20);
		$table->string('clock_in',20)->nullable()->default('NULL');
		$table->string('clock_in_optional',20)->nullable()->default('NULL');
		$table->string('clock_out',20)->nullable()->default('NULL');
		$table->string('late',10)->nullable()->default('NULL');
		$table->string('early_leaving',10)->nullable()->default('NULL');
		$table->string('overtime',10)->nullable()->default('NULL');
		$table->string('total',10)->nullable()->default('NULL');
		$table->enum('status',['Absent','Holiday','Present']);
		$table->enum('pay_status',['Paid','Unpaid'])->default('Unpaid');
		$table->enum('clock_status',['Clock In','Clock Out'])->default('Clock Out');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_attendance');
    }
}