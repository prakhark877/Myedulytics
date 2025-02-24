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
        Schema::create('cms_pages', function (Blueprint $table) {
            $table->id('page_id'); // Auto Increment INT
            $table->string('page_slug', 800)->nullable(); // VARCHAR(800) NULL
            $table->string('page_title', 245)->nullable(); // VARCHAR(245) NULL
            $table->text('short_desc')->nullable(); // TEXT NULL
            $table->longText('content')->nullable(); // TEXT NULL
            $table->string('page_type', 200)->nullable(); // VARCHAR(100) NULL (Assuming 100 length)
            $table->string('pg_bgimg', 245)->nullable();
            $table->integer('cat_id')->unsigned()->nullable();
            $table->integer('subcat_id')->unsigned()->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_pages');
    }
};
