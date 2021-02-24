<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysEmployeeBankAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('sys_employee_bank_accounts', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('emp_id',11);
		$table->string('bank_name',100);
		$table->string('branch_name',100);
		$table->string('account_name',100);
		$table->string('account_number',100);
		$table->string('ifsc_code',100);
		$table->string('pan_no',100);
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_employee_bank_accounts');
    }
}