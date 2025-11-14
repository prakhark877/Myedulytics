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
        Schema::create('marksheets', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();             // custom description
            $table->string('image')->nullable();                 // image path
            $table->longText('image_description')->nullable();   // full Textract extracted text
            $table->json('textract_raw')->nullable();            // raw Textract block data (optional)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // belongs to user
            $table->string('exam_type')->nullable();             // exam type
            $table->date('issued_at')->nullable();               // issue date
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marksheets');
    }
};
