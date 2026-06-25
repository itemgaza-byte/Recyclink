<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FavoriteListing extends Model
{
    protected $table = 'favorite_listings';

    protected $fillable = ['buyer_id', 'listing_id'];

    public function buyer(): BelongsTo   { return $this->belongsTo(User::class, 'buyer_id'); }
    public function listing(): BelongsTo { return $this->belongsTo(WasteListing::class); }
}
