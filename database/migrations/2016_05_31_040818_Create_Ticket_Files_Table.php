<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysTicketFilesTable extends Migration
{
    public function up()
    {
        Schema::create('sys_ticket_files', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('ticket_id',11);
		$table->integer('emp_id',11);
		$table->text('file_title');
		$table->string('file_size',20);
		$table->text('file');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_ticket_files');
    }
}