<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained('seller_wallets')->cascadeOnDelete()->index();
            $table->decimal('amount', 12, 2);
            $table->string('bank_name', 100);
            $table->string('bank_account_number', 50);
            $table->string('bank_account_name', 100);
            $table->string('status')->default('pending')->index();
            $table->text('admin_note')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            // ponytail: keep — needed for admin approval audit
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('admin_fee', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2)->nullable();
            $table->string('withdrawal_number', 40)->nullable()->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
