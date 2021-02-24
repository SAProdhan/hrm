<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysTrainingEventsTable extends Migration
{
    public function up()
    {
        Schema::create('sys_training_events', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->enum('training_type',['Online Training','Seminar','Lecture','Workshop','Hands On Training','Webinar']);
		$table->enum('training_subject',['HR Training','Employees Development','IT Training','Finance Training','Others']);
		$table->enum('training_nature',['Internal','External']);
		$table->text('title');
		$table->text('training_location');
		$table->text('sponsored_by');
		$table->text('organized_by');
		$table->date('training_from');
		$table->date('training_to');
		$table->enum('status',['upcoming','completed'])->default('upcoming');
		$table->text('externals');
		$table->text('description');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_training_events');
    }
}