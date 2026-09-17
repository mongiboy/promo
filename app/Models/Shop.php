<?php

namespace App\Models;

use App\Enums\PartnerNetwork;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    protected $fillable = [
        'is_active',
        'slug',
        'meta_title',
        'meta_description',
        'name',
        'alt_name',
        'seo_text',
        'url',
        'logo',
        'aliases',
        'networks',
        'sort',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    protected $casts = [
        'networks' => 'array',
    ];

    public function scopeVisible(Builder $query): void
    {
        $query->where('is_active', true)
            ->whereHas('offers', fn (Builder $q) => $q->published());
    }
}
