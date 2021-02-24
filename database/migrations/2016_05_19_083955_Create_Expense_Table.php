<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysExpenseTable extends Migration
{
    public function up()
    {
        Schema::create('sys_expense', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->string('item_name',100);
		$table->text('purchase_from');
		$table->date('purchase_date');
		$table->integer('purchase_by',11);
		$table->decimal('amount',10,2);
		$table->enum('status',['Pending','Approved','Cancel'])->default('Pending');
		$table->text('bill_copy');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_expense');
    }
}