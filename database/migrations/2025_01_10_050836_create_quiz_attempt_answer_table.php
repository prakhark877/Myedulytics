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
        Schema::create('quiz_attempt_answer', function (Blueprint $table) {
            $table->id();
            $table->integer('quiz_id');
            $table->text('total_attempt_question')->nullable();
            $table->text('total_attempt_time')->nullable();
            $table->text('total_correct_answer')->nullable();
            $table->integer('user_id')->nullable();
            $table->longText('answer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempt_answer');
    }
};
