<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->index()->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->index()->constrained('waste_categories')->restrictOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('quantity', 10, 2);
            $table->string('unit');
            $table->decimal('price_per_unit', 12, 2);
            $table->text('address');
            $table->string('city')->index();
            $table->string('province')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('availability_status')->default('available')->index();
            $table->string('verification_status')->default('pending')->index();
            $table->text('admin_note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // ponytail: keep — useful for search/analytics
            $table->string('slug')->unique()->index();
            $table->decimal('min_order', 10, 2)->default(1);
            $table->string('waste_condition', 30)->default('used');
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamp('published_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_listings');
    }
};
