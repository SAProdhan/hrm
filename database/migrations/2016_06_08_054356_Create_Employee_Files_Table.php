<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysEmployeeFilesTable extends Migration
{
    public function up()
    {
        Schema::create('sys_employee_files', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('emp_id',11);
		$table->string('file_title',100);
		$table->text('file');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_employee_files');
    }
}