<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Domain\Providers\Enums\ProviderStatus;
use Domain\Providers\Enums\BadgeLevel;

/**
 * ProviderProfile Model
 * EN: Represents a service provider's public profile.
 * AR: يمثل الملف التعريفي العام لمقدم الخدمة.
 */
class ProviderProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','category_id','display_name','bio','city','cities_json','skills_json','photos_json','badge_level','status','avg_rating','completed_jobs','social_json','website'
    ];

    protected $casts = [
        'cities_json' => 'array',
        'skills_json' => 'array',
        'photos_json' => 'array',
        'social_json' => 'array',
        'avg_rating' => 'decimal:2',
    ];

    /**
     * Scope: basic text search on display_name or bio. EN+AR
     * EN: Filters by partial match on name or bio.
     * AR: تصفية حسب جزء من الاسم أو الوصف.
     */
    public function scopeSearch($query, ?string $q)
    {
        if(!$q){ return $query; }
        return $query->where(function($w) use ($q){
            $w->where('display_name','like','%'.$q.'%')
              ->orWhere('bio','like','%'.$q.'%');
        });
    }

    /**
     * Accessor: status enum cast (manual for portability)
     */
    public function getStatusEnumAttribute(): ?ProviderStatus
    {
        return $this->status ? ProviderStatus::from($this->status) : null;
    }

    /**
     * Mutator: assign status from enum
     */
    public function setStatusEnumAttribute(ProviderStatus $status): void
    {
        $this->attributes['status'] = $status->value;
    }

    public function getBadgeLevelEnumAttribute(): ?BadgeLevel
    {
        return $this->badge_level ? BadgeLevel::from($this->badge_level) : null;
    }

    public function setBadgeLevelEnumAttribute(BadgeLevel $badge): void
    {
        $this->attributes['badge_level'] = $badge->value;
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'provider_services', 'provider_id', 'service_id')
            ->withPivot(['price_min','price_max'])
            ->withTimestamps();
    }

    /** Offers submitted by provider */
    public function offers()
    {
        return $this->hasMany(Offer::class, 'provider_id');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeCity($query, ?string $city)
    {
        return $city ? $query->where('city', $city) : $query;
    }

    public function scopeBadge($query, ?string $level)
    {
        return $level ? $query->where('badge_level', $level) : $query;
    }

    public function scopeMinRating($query, ?float $min)
    {
        return $min !== null ? $query->where('avg_rating', '>=', $min) : $query;
    }

    public function scopeWithService($query, $serviceIdOrSlug)
    {
        if (!$serviceIdOrSlug) { return $query; }
        return $query->whereHas('services', function($q) use ($serviceIdOrSlug) {
            if (is_numeric($serviceIdOrSlug)) {
                $q->where('services.id', $serviceIdOrSlug);
            } else {
                $q->where('services.slug', $serviceIdOrSlug);
            }
        });
    }
}
