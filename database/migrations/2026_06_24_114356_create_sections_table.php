<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();

            $table->string('section_id')->unique();
            $table->string('course_code');
            $table->string('section_code');

            $table->integer('year_level');

            $table->string('day_schedule');

            $table->time('start_time');
            $table->time('end_time');

            $table->string('professor');

            $table->integer('max_students');

            $table->timestamps();
        });
    }
};
