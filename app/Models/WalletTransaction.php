<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id', 'order_id', 'transaction_type', 'amount', 'description',
        // ponytail: keep — audit trail requires balance snapshots
        'reference_number', 'balance_before', 'balance_after',
    ];

    protected function casts(): array
    {
        return [
            'amount'         => 'decimal:2',
            'balance_before' => 'decimal:2',
            'balance_after'  => 'decimal:2',
        ];
    }

    public function isCredit(): bool { return $this->transaction_type === 'credit'; }
    public function isDebit(): bool  { return $this->transaction_type === 'debit'; }

    public function wallet(): BelongsTo { return $this->belongsTo(SellerWallet::class, 'wallet_id'); }
    public function order(): BelongsTo  { return $this->belongsTo(Order::class); }
}
