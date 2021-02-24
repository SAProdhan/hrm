<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysSupportDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::create('sys_support_departments', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->text('name');
		$table->text('email');
		$table->integer('order',11);
		$table->enum('show',['Yes','No'])->default('Yes');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_support_departments');
    }
}