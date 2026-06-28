<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('payment_method');
            $table->string('payment_gateway')->nullable();
            $table->string('payment_reference')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('payment_status')->default('pending')->index();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();

            // ponytail: keep — needed for full gateway integration
            $table->string('payment_number', 40)->nullable()->unique();
            $table->string('payment_channel', 50)->nullable();
            $table->string('gateway_transaction_id')->nullable()->index();
            $table->json('gateway_response')->nullable();
            $table->string('virtual_account_number')->nullable();
            $table->string('qris_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
