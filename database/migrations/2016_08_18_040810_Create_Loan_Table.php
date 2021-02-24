<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysLoanTable extends Migration
{
    public function up()
    {
        Schema::create('sys_loan', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('emp_id',11);
		$table->text('title');
		$table->date('loan_date');
		$table->decimal('amount',10,2)->default('0.00');
		$table->enum('enable_payslip',['yes','no'])->default('yes');
		$table->decimal('repayment_amount',10,2)->default('0.00');
		$table->decimal('remaining_amount',10,2)->default('0.00');
		$table->date('repayment_start_date');
		$table->text('description');
		$table->enum('status',['ongoing','completed','rejected','pending'])->default('pending');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_loan');
    }
}