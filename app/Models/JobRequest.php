<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Offer;

/**
 * JobRequest Model
 * EN: Represents a client's service/job request.
 * AR: يمثل طلب خدمة من العميل.
 */
class JobRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id','category_id','service_id','details','photos_json','city','status'
    ];

    protected $casts = [
        'photos_json' => 'array'
    ];

    public function client(): BelongsTo { return $this->belongsTo(User::class, 'client_id'); }
    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function service(): BelongsTo { return $this->belongsTo(Service::class); }
    public function offers(): HasMany { return $this->hasMany(Offer::class, 'request_id'); }
}
