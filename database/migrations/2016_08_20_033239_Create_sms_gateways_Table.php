<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysSmsGatewaysTable extends Migration
{
    public function up()
    {
        Schema::create('sys_sms_gateways', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->text('name');
		$table->text('api_link');
		$table->text('user_name');
		$table->text('password');
		$table->text('api_id');
		$table->enum('status',['Active','Inactive']);
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_sms_gateways');
    }
}