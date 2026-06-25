<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    public const UPDATED_AT = null; // ponytail: logs are immutable

    protected $fillable = [
        'user_id', 'action', 'table_name', 'record_id', 'description',
        'ip_address', 'user_agent', 'properties',
    ];

    protected function casts(): array { return ['properties' => 'array']; }

    public static function record(string $action, ?string $tableName = null, ?int $recordId = null, ?string $description = null, array $properties = []): static
    {
        return static::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'table_name'  => $tableName,
            'record_id'   => $recordId,
            'description' => $description,
            'properties'  => $properties ?: null,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
