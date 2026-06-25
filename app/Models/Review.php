<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'reviewer_id', 'reviewed_user_id', 'rating', 'review_text',
        // ponytail: keep — listing ref + anonymous + seller reply are product features
        'listing_id', 'is_anonymous', 'seller_reply', 'seller_replied_at',
    ];

    protected function casts(): array
    {
        return [
            'rating'            => 'integer',
            'is_anonymous'      => 'boolean',
            'seller_replied_at' => 'datetime',
        ];
    }

    public function scopePositive($query) { return $query->where('rating', '>=', 4); }
    public function scopeNegative($query) { return $query->where('rating', '<=', 2); }

    public function order(): BelongsTo        { return $this->belongsTo(Order::class); }
    public function reviewer(): BelongsTo     { return $this->belongsTo(User::class, 'reviewer_id'); }
    public function reviewedUser(): BelongsTo { return $this->belongsTo(User::class, 'reviewed_user_id'); }
    public function listing(): BelongsTo      { return $this->belongsTo(WasteListing::class)->withTrashed(); }
}
