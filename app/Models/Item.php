<?php

namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ulid',
        'name',
        'description',
        'import_ref',
        'notes',
        'quantity',
        'insured',
        'archived',
        'asset_id',
        'serial_number',
        'model_number',
        'manufacturer',
        'lifetime_warranty',
        'warranty_expires',
        'warranty_details',
        'purchase_time',
        'purchase_from',
        'purchase_price',
        'sold_time',
        'sold_to',
        'sold_price',
        'sold_notes',
        'location_id',
        'team_id',
        'fields',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->ulid = self::generateUlid();
            if (auth()->check()) {
                $item->team_id = Filament::getTenant()?->id;
            }
        });
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    protected function casts(): array
    {
        return [
            'ulid' => 'string',
            'warranty_expires' => 'datetime',
            'purchase_time' => 'datetime',
            'sold_time' => 'datetime',
            'insured' => 'boolean',
            'archived' => 'boolean',
            'quantity' => 'integer',
            'fields' => 'array',
        ];
    }

    public static function generateUlid(): string
    {
        return strtolower((string) Str::ulid());
    }
}
