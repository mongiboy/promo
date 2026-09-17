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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->text('seo_text')->nullable();
            $table->boolean('is_active')->default(false);
            $table->unsignedInteger('sort')->default(999);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
