<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WasteCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id', 'category_name', 'slug', 'description',
        'is_active', 'icon', 'color', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeActive($query)        { return $query->where('is_active', true); }
    public function scopeRootCategories($query){ return $query->whereNull('parent_id'); }

    public function parent(): BelongsTo    { return $this->belongsTo(WasteCategory::class, 'parent_id'); }
    public function children(): HasMany    { return $this->hasMany(WasteCategory::class, 'parent_id')->orderBy('sort_order'); }
    public function listings(): HasMany    { return $this->hasMany(WasteListing::class, 'category_id'); }
}
