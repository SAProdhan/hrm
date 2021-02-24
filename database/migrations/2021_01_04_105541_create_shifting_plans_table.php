<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftingPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifting_plans', function (Blueprint $table) {
            $table->foreignId('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreignId('shift_id')->references('id')->on('shifts')->onDelete('cascade');
            $table->integer('sequence');
            $table->integer('days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifting_plans');
    }
}
