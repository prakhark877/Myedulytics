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
        Schema::create('users', function (Blueprint $table) {
             $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('preferred_name');
            $table->date('dob');
            $table->string('student_email')->unique();
            $table->string('student_password');
            $table->string('parent_email')->unique();
            $table->string('parent_password');
            $table->string('country');
            $table->string('region');
            $table->enum('preset',['GEMS-DXB','DPS-DEL','PS-CA']);
            $table->enum('curriculum',['CBSE','ICSE','IB','Cambridge (IGCSE)','US (AP)','Other']);
            $table->enum('grade',['1','2','3','4','5','6','7','8','9','10','11','12']);
            $table->string('languages');
            $table->string('academic');
            $table->string('activities');
            $table->integer('studyhours');
            $table->json('learningpreferences')->nullable();
            $table->json('consent')->nullable();
            // $table->string('learningpreferences',[]);
            // $table->string('city');
            // $table->string('city');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
