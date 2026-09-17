<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = [
        'meta_title',
        'meta_description',
        'slug',
        'name',
        'seo_text',
        'is_active',
        'sort',
    ];

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class);
    }
}
