<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysTaskTable extends Migration
{
    public function up()
    {
        Schema::create('sys_task', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->text('task');
		$table->date('start_date')->nullable()->default('NULL');
		$table->date('due_date')->nullable()->default('NULL');
		$table->integer('estimated_hour',11)->nullable()->default('NULL');
		$table->text('description');
		$table->integer('progress',11)->default('0');
		$table->enum('status',['pending','started','completed']);
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_task');
    }
}