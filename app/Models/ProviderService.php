<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * ProviderService Pivot
 * EN: Pivot model linking provider profiles to services with pricing.
 * AR: نموذج وسيط يربط ملفات المزود بالخدمات مع التسعير.
 */
class ProviderService extends Pivot
{
    protected $table = 'provider_services';
    protected $fillable = ['provider_id','service_id','price_min','price_max'];
}
