<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SellerWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id', 'balance', 'pending_balance', 'total_earned', 'total_withdrawn',
    ];

    protected function casts(): array
    {
        return [
            'balance'          => 'decimal:2',
            'pending_balance'  => 'decimal:2',
            'total_earned'     => 'decimal:2',
            'total_withdrawn'  => 'decimal:2',
        ];
    }

    public function canWithdraw(float $amount): bool { return $this->balance >= $amount && $amount > 0; }

    public function seller(): BelongsTo        { return $this->belongsTo(User::class, 'seller_id'); }
    public function transactions(): HasMany    { return $this->hasMany(WalletTransaction::class, 'wallet_id')->latest(); }
    public function withdrawals(): HasMany     { return $this->hasMany(Withdrawal::class, 'wallet_id'); }
}
