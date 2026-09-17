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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->restrictOnDelete();

            $table->string('title', 256);
            $table->text('description')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('discount')->nullable();
            $table->string('promocode')->nullable();
            $table->string('url', 2048);
            $table->string('erid')->unique();
            $table->unsignedInteger('manual_sort')->default(10);
            $table->decimal('rating', 4, 2)->nullable();
            $table->boolean('is_moderated')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_rejected')->default(false);
            $table->string('partner_network', 50);
            $table->string('external_id')->nullable();

            $table->unsignedInteger('clicks_count')->default(0);

            $table->index(['shop_id', 'is_active', 'is_moderated']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
