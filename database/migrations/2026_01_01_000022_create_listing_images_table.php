<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->index()->constrained('waste_listings')->cascadeOnDelete();
            $table->string('image_url');
            $table->boolean('is_primary')->default(false)->index();
            $table->timestamps();

            // ponytail: keep — needed for cloud storage (S3) support
            $table->string('disk', 20)->default('public');
            $table->unsignedSmallInteger('sort_order')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_images');
    }
};
