<?php

namespace App\Models;

use App\Enums\PartnerNetwork;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offer extends Model
{
    protected $fillable = [
        'shop_id',
        'title',
        'description',
        'starts_at',
        'expires_at',
        'discount',
        'promocode',
        'url',
        'manual_sort',
        'rating',
        'is_moderated',
        'is_active',
        'partner_network',
        'external_id',
    ];

    use HasFactory;

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    protected $casts = [
        'partner_network' => PartnerNetwork::class,
        'expires_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_active', true)
                     ->where('is_moderated', true)
                     ->where('is_rejected', false)
                     ->where(function ($q) {
                        $q->whereNull('expires_at')
                            ->orWhere('expires_at', '>', now());
                     });
    }

    public function scopeForModeration($query)
    {
        return $query->where('is_active', true)
            ->where('is_moderated', false)
            ->where('is_rejected', false)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

}
