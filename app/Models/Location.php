<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function childrens(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Location::class, 'parent_id');
    }
}
