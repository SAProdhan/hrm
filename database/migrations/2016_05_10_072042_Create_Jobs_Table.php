<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysJobsTable extends Migration
{
    public function up()
    {
        Schema::create('sys_jobs', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('position',11);
		$table->integer('no_position',11);
		$table->enum('job_type',['Contractual','Part Time','Full Time'])->nullable()->default('NULL');
		$table->text('experience');
		$table->text('age');
		$table->text('job_location');
		$table->text('salary_range');
		$table->text('short_description');
		$table->date('post_date');
		$table->date('apply_date')->nullable()->default('NULL');
		$table->date('close_date')->nullable()->default('NULL');
		$table->enum('status',['opening','closed','drafted']);
		$table->text('description');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_jobs');
    }
}