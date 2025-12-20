<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider_name',
        'phone',
        'category_id',
        'city',
        'description',
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'meta',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
