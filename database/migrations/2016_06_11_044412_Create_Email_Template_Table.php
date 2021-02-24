<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysEmailTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('sys_email_templates', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->text('tplname');
		$table->text('subject');
		$table->text('message');
		$table->enum('status',['1','0'])->default('1');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_email_templates');
    }
}