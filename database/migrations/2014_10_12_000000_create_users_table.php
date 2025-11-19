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
            $table->id(); // Auto-incrementing primary key
            $table->string('student_id')->unique(); // Unique student ID
            $table->string('first_name'); // First name is required
            $table->string('last_name')->nullable(); // Last name can be null
            $table->string('name'); // Full name or display name
            $table->string('email')->unique(); // Email must be unique
            $table->string('phone')->nullable(); // Optional phone number
            $table->date('dob')->nullable(); // Date of birth as DATE type
            $table->string('school_name')->nullable(); // Optional school name
            $table->string('parent_email')->nullable(); // Optional parent's name
            $table->text('address')->nullable(); // Longer text for address
            $table->string('city')->nullable(); // City name
            $table->string('state')->nullable(); // State name
            $table->string('zip', 10)->nullable(); // ZIP code with a max length of 10
            $table->enum('gender', ['male', 'female', 'other'])->nullable(); // Gender with predefined options
            $table->timestamp('email_verified_at')->nullable(); // Email verification timestamp
            $table->string('password'); // Hashed password
            $table->integer('type')->default(2);
            $table->rememberToken(); // Token for "remember me" functionality
            $table->timestamps(); // Created at and Updated at timestamps
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
