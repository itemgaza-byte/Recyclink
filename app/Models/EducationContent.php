<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'admin_id', 'title', 'slug', 'content', 'thumbnail_url',
        'content_type', 'status', 'published_at',
        // ponytail: keep
        'excerpt', 'view_count', 'is_featured',
    ];

    protected function casts(): array
    {
        return ['is_featured' => 'boolean', 'published_at' => 'datetime'];
    }

    public function scopePublished($query) { return $query->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now()); }
    public function scopeFeatured($query)  { return $query->where('is_featured', true); }

    public function admin(): BelongsTo { return $this->belongsTo(User::class, 'admin_id'); }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(WasteCategory::class, 'education_content_category');
    }
}
