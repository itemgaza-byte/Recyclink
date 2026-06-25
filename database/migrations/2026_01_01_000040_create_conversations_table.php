<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->nullable()->constrained('waste_listings')->nullOnDelete();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete()->index();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete()->index();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
