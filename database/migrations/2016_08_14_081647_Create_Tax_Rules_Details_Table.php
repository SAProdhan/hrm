<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysTaxRulesDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('sys_tax_rules_details', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('tax_id',11);
		$table->string('salary_from',10)->default('0');
		$table->string('salary_to');
		$table->string('tax_percentage')->default('0');
		$table->string('additional_tax_amount')->default('0');
		$table->enum('gender',['Both','Male','Female'])->default('Both');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_tax_rules_details');
    }
}