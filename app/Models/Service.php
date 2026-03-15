<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Service model — الخدمة
 * EN: Represents a service under a category.
 * AR: يمثل خدمة تابعة لتصنيف.
 */
class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'name_ar', 'slug', 'summary', 'summary_ar', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** Providers offering this service */
    public function providers(): BelongsToMany
    {
        return $this->belongsToMany(ProviderProfile::class, 'provider_services', 'service_id', 'provider_id')
            ->withPivot(['price_min','price_max'])
            ->withTimestamps();
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

    /**
     * Get localized summary based on current locale
     * AR: الملخص المترجم حسب اللغة الحالية
     */
    public function getLocalizedSummaryAttribute(): ?string
    {
        if (app()->getLocale() === 'ar' && !empty($this->summary_ar)) {
            return $this->summary_ar;
        }
        return $this->summary;
    }
}
