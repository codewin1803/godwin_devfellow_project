<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('timetables', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('school_id');
        $table->unsignedBigInteger('class_level_id');
        $table->unsignedBigInteger('subject_id');
        $table->unsignedBigInteger('teacher_id');
        $table->tinyInteger('weekday'); // 1=Mon ... 7=Sun
        $table->time('start_time');
        $table->time('end_time');
        $table->timestamps();

        $table->foreign('class_level_id')->references('id')->on('class_levels')->cascadeOnDelete();
        $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnDelete();
        $table->foreign('teacher_id')->references('id')->on('users')->cascadeOnDelete();
    });
}

};
