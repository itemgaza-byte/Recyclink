<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerProfile extends Model
{
    use HasFactory;

    public const VERIFICATION_PENDING = 'pending';
    public const VERIFICATION_VERIFIED = 'verified';
    public const VERIFICATION_REJECTED = 'rejected';

    protected $fillable = [
        'user_id', 'business_name', 'business_type', 'address', 'city', 'province',
        'latitude', 'longitude', 'bank_name', 'bank_account_number', 'bank_account_name',
        'verification_status', 'npwp', 'nib', 'description', 'postal_code',
        'rejection_reason', 'verified_at',
    ];

    protected function casts(): array
    {
        return ['verified_at' => 'datetime', 'latitude' => 'decimal:8', 'longitude' => 'decimal:8'];
    }

    public function isVerified(): bool { return $this->verification_status === self::VERIFICATION_VERIFIED; }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
