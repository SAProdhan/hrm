<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysEmployeeRolesTable extends Migration
{
    public function up()
    {
        Schema::create('sys_employee_roles', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->text('role_name');
		$table->enum('status',['Active','Inactive'])->default('Active');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_employee_roles');
    }
}
