<?php

namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends \Spatie\Tags\Tag
{
    protected function casts(): array
    {
        return [
            'name' => 'array',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($item) {
            if (auth()->check()) {
                $item->team_id = Filament::getTenant()?->id;
            }
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Item::class, 'taggable');
    }
}
