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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('cat_title'); // Column for category name
            $table->string('cat_slug')->nullable(); // Column for category name
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('categories');
    }
    
};
