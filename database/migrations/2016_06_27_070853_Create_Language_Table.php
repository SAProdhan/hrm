<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysLanguageTable extends Migration
{
    public function up()
    {
        Schema::create('sys_language', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->string('language',100);
		$table->enum('status',['Active','Inactive']);
		$table->text('icon');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_language');
    }
}