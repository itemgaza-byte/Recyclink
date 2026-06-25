<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->longText('content');
            $table->string('thumbnail_url')->nullable();
            $table->string('content_type')->default('article')->index();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // ponytail: keep — excerpt/view_count/featured needed for listing page
            $table->text('excerpt')->nullable();
            $table->unsignedBigInteger('view_count')->default(0);
            $table->boolean('is_featured')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('education_contents');
    }
};
