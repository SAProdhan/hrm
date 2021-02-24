<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysDisableMenuTable extends Migration
{
    public function up()
    {
        Schema::create('sys_disable_menu', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->text('emp_ids');
		$table->string('menu',100);
		$table->enum('status',['active','inactive']);
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_disable_menu');
    }
}