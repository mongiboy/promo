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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_active')->default(false);
            $table->string('slug')->unique();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('name');
            $table->string('alt_name')->nullable();
            $table->text('seo_text')->nullable();
            $table->string('url')->unique();
            $table->string('logo')->nullable();
            $table->text('aliases')->nullable();
            $table->json('networks')->nullable();

            $table->unsignedInteger('sort')->default(999);

            $table->index(['is_active', 'sort']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
