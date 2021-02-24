<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysDesignationTable extends Migration
{
    public function up()
    {
        Schema::create('sys_designation', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('did',11);
		$table->text('designation');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_designation');
    }
}