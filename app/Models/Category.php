<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Category model — التصنيف
 * EN: Represents a service category.
 * AR: يمثل تصنيف الخدمات.
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'position', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'position' => 'integer',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
