<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysProvidentFundTable extends Migration
{
    public function up()
    {
        Schema::create('sys_provident_fund', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('emp_id',11);
		$table->enum('provident_fund_type',['Fixed Amount','Percentage of Basic Salary'])->default('Percentage of Basic Salary');
		$table->string('employee_share',10)->default('0');
		$table->string('organization_share',10)->default('0');
		$table->text('description');
		$table->decimal('total',10,2)->default('0.00');
		$table->enum('payment_type',['Cash Payment','Bank Payment','Cheque Payment'])->nullable()->default('NULL');
		$table->enum('status',['Paid','Unpaid'])->default('Unpaid');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_provident_fund');
    }
}