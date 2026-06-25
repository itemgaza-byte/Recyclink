<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('waste_categories')->nullOnDelete(); // ponytail: keep hierarchy
            $table->string('category_name');
            $table->string('slug')->unique()->index();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->index();
            // ponytail: keep — needed for UI rendering
            $table->string('icon')->nullable();
            $table->string('color', 20)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_categories');
    }
};
