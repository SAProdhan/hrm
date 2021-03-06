<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingMembersTable extends Migration
{
    public function up()
    {
        Schema::create('training_members', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('training_id',11);
		$table->integer('emp_id',11);
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('training_members');
    }
}