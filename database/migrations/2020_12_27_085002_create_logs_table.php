<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('logs', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('device_id')->nullable()->unsigned();
        //     $table->integer('uid')->nullable()->unsigned();
        //     $table->timestamp('timestamp');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('logs');
    }
}
