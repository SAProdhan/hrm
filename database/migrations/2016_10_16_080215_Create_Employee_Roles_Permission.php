<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysEmployeeRolesPermissionTable extends Migration
{
    public function up()
    {
        Schema::create('sys_employee_roles_permission', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('role_id',11);
		$table->integer('perm_id',11);
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_employee_roles_permission');
    }
}