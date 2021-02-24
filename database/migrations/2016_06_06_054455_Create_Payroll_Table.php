<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysPayrollTable extends Migration
{
    public function up()
    {
        Schema::create('sys_payroll', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('emp_id',11);
		$table->integer('department',11);
		$table->integer('designation',11);
		$table->string('payment_month',100);
		$table->date('payment_date')->default('2017-06-14');
		$table->string('net_salary',50);
		$table->string('tax',50);
		$table->string('provident_fund',50)->default('0');
		$table->string('loan',50)->default('0');
		$table->string('overtime_salary',50);
		$table->string('total_salary',50);
		$table->enum('payment_type',['Cash Payment','Bank Payment','Cheque Payment']);
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_payroll');
    }
}