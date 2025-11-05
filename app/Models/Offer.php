<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Offer Model
 * EN: Provider's offer/quote for a job request.
 * AR: عرض مقدم الخدمة لطلب الخدمة.
 */
class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id','provider_id','note','eta_days','price','status'
    ];

    public function request(): BelongsTo { return $this->belongsTo(JobRequest::class, 'request_id'); }
    public function provider(): BelongsTo { return $this->belongsTo(ProviderProfile::class, 'provider_id'); }
}
