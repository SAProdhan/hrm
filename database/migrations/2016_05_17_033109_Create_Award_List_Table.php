<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysAwardListTable extends Migration
{
    public function up()
    {
        Schema::create('sys_award_list', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->text('emp_id');
		$table->integer('award',11);
		$table->string('gift',200);
		$table->string('cash',100)->nullable()->default('NULL');
		$table->string('month',20);
		$table->integer('year',11);
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_award_list');
    }
}