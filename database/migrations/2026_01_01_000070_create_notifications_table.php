<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->index();
            $table->string('title');
            $table->text('message');
            $table->string('notification_type');
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->boolean('is_read')->default(false)->index();
            $table->timestamps();

            $table->index(['user_id', 'is_read']);

            // ponytail: keep — JSON payload and read_at avoid extra queries
            $table->json('data')->nullable();
            $table->timestamp('read_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
