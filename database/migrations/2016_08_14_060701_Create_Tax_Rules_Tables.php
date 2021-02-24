<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysTaxRulesTable extends Migration
{
    public function up()
    {
        Schema::create('sys_tax_rules', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->text('tax_name');
		$table->enum('status',['active','inactive'])->default('active');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_tax_rules');
    }
}