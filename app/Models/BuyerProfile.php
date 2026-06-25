<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuyerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'company_name', 'buyer_type', 'address', 'city', 'province',
        'latitude', 'longitude', 'postal_code', 'industry_type',
    ];

    protected function casts(): array
    {
        return ['latitude' => 'decimal:8', 'longitude' => 'decimal:8'];
    }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
