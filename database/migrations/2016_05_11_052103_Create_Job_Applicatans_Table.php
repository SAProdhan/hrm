<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysJobApplicantsTable extends Migration
{
    public function up()
    {
        Schema::create('sys_job_applicants', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('job_id',11);
		$table->string('name',100);
		$table->string('email',150);
		$table->string('phone',20);
		$table->enum('status',['Unread','Rejected','Primary Selected','Call For Interview','Confirm'])->default('Unread');
		$table->text('resume');
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_job_applicants');
    }
}