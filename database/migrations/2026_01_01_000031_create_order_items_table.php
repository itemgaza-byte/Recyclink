<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete()->index();
            $table->foreignId('listing_id')->nullable()->constrained('waste_listings')->nullOnDelete()->index();
            $table->string('waste_name_snapshot');
            $table->decimal('quantity', 10, 2);
            $table->string('unit');
            $table->decimal('price_per_unit_snapshot', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
