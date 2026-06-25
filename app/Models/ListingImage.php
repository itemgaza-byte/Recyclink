<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ListingImage extends Model
{
    use HasFactory;

    protected $fillable = ['listing_id', 'image_url', 'disk', 'is_primary', 'sort_order'];

    protected function casts(): array { return ['is_primary' => 'boolean']; }

    // ponytail: accessor resolves disk-aware URL transparently
    public function getUrlAttribute(): string
    {
        return str_starts_with($this->image_url, 'http')
            ? $this->image_url
            : Storage::disk($this->disk)->url($this->image_url);
    }

    public function listing(): BelongsTo { return $this->belongsTo(WasteListing::class); }
}
