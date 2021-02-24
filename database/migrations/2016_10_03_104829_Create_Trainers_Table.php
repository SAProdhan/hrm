<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysTrainersTable extends Migration
{
    public function up()
    {
        Schema::create('sys_trainers', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->string('first_name',50);
		$table->string('last_name',50)->nullable()->default('NULL');
		$table->string('designation',50);
		$table->text('organization');
		$table->text('address');
		$table->string('city',50)->nullable()->default('NULL');
		$table->string('state',50)->nullable()->default('NULL');
		$table->string('zip',20)->nullable()->default('NULL');
		$table->string('country',50)->nullable()->default('NULL');
		$table->text('email_address');
		$table->string('phone',30);
		$table->text('expertise');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_trainers');
    }
}