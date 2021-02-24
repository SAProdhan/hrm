<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysTrainingNeedsAssessmentTable extends Migration
{
    public function up()
    {
        Schema::create('sys_training_needs_assessment', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('department',11);
		$table->enum('training_type',['Online Training','Seminar','Lecture','Workshop','Hands On Training','Webinar']);
		$table->enum('training_subject',['HR Training','Employees Development','IT Training','Finance Training','Others']);
		$table->enum('training_nature',['Internal','External']);
		$table->text('title');
		$table->text('training_reason');
		$table->integer('trainer',11)->nullable()->default('NULL');
		$table->text('training_location');
		$table->date('training_from');
		$table->date('training_to');
		$table->decimal('training_cost',10,2)->default('0.00');
		$table->decimal('travel_cost',10,2)->default('0.00');
		$table->enum('status',['pending','approved','rejected','completed'])->default('pending');
		$table->text('description');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_training_needs_assessment');
    }
}