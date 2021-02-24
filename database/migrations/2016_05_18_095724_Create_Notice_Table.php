<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysNoticeTable extends Migration
{
    public function up()
    {
        Schema::create('sys_notice', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->text('title');
		$table->enum('status',['Published','Unpublished']);
		$table->text('description');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_notice');
    }
}