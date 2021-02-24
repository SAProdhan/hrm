<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysExpenseTitleTable extends Migration
{
    public function up()
    {
        Schema::create('sys_expense_title', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->string('expense',100);
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_expense_title');
    }
}