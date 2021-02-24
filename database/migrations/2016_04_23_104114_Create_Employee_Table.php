<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysAppconfigTable extends Migration
{
    public function up()
    {
        Schema::create('sys_appconfig', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->text('setting');
		$table->text('value');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_appconfig');
    }
}