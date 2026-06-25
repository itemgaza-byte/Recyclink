<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete()->index();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('message_text')->nullable();
            $table->string('message_type')->default('text');
            $table->boolean('is_read')->default(false)->index();
            $table->timestamps();

            // ponytail: keep — attachment is a core chat feature
            $table->string('attachment_path')->nullable();
            $table->string('attachment_type')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
