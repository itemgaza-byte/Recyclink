<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'listing_id',
        'waste_name_snapshot', 'quantity', 'unit', 'price_per_unit_snapshot', 'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'quantity'              => 'decimal:2',
            'price_per_unit_snapshot' => 'decimal:2',
            'subtotal'              => 'decimal:2',
        ];
    }

    public function order(): BelongsTo   { return $this->belongsTo(Order::class); }
    public function listing(): BelongsTo { return $this->belongsTo(WasteListing::class)->withTrashed(); }
}
