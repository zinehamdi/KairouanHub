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
        'name',
        'name_ar',
        'slug',
        'description',
        'icon',
        'position',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'position' => 'integer',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get localized name based on current locale
     * AR: الاسم المترجم حسب اللغة الحالية
     */
    public function getLocalizedNameAttribute(): string
    {
        if (app()->getLocale() === 'ar' && !empty($this->name_ar)) {
            return $this->name_ar;
        }
        return $this->name ?? '';
    }
}
