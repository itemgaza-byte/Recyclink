<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 30)->unique()->index();
            $table->foreignId('buyer_id')->constrained('users')->restrictOnDelete()->index();
            $table->foreignId('seller_id')->constrained('users')->restrictOnDelete()->index();
            $table->string('order_status')->default('pending')->index();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->string('pickup_method')->nullable();
            $table->date('pickup_date')->nullable();
            $table->time('pickup_time')->nullable();
            $table->text('pickup_address')->nullable();
            $table->text('buyer_note')->nullable();
            $table->text('seller_note')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // ponytail: keep — needed for financial reconciliation
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('platform_fee', 12, 2)->default(0);
            $table->string('tracking_number')->nullable();
            $table->text('cancellation_reason')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
