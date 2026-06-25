<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('section_id');
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('section_id')->references('id')->on('sections');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};