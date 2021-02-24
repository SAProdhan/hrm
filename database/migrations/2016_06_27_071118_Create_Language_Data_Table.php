<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysLanguageDataTable extends Migration
{
    public function up()
    {
        Schema::create('sys_language_data', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('lan_id',11);
		$table->text('lan_data');
		$table->text('lan_value');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_language_data');
    }
}