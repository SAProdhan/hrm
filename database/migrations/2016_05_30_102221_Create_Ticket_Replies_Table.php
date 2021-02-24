<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysTicketRepliesTable extends Migration
{
    public function up()
    {
        Schema::create('sys_ticket_replies', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('tid',11);
		$table->integer('emp_id',11);
		$table->text('name');
		$table->date('date');
		$table->text('message');
		$table->text('admin');
		$table->text('image');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_ticket_replies');
    }
}