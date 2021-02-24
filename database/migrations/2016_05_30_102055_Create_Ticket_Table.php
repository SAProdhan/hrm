<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('sys_tickets', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('did',11);
		$table->integer('emp_id',11);
		$table->text('name');
		$table->text('email');
		$table->date('date');
		$table->text('subject');
		$table->text('message');
		$table->enum('status',['Pending','Answered','Customer Reply','Closed'])->default('Pending');
		$table->text('admin');
		$table->text('replyby');
		$table->text('closed_by');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_tickets');
    }
}