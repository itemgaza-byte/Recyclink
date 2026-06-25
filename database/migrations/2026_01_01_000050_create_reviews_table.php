<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reviewed_user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('review_text')->nullable();
            $table->timestamps();

            $table->unique(['order_id', 'reviewer_id']); // per spec

            // ponytail: keep — anonymous reviews + seller reply are product features
            $table->foreignId('listing_id')->nullable()->constrained('waste_listings')->nullOnDelete();
            $table->boolean('is_anonymous')->default(false);
            $table->text('seller_reply')->nullable();
            $table->timestamp('seller_replied_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
