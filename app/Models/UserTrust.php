<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTrust extends Model
{
    use HasFactory;

    protected $table = 'user_trust';

    protected $fillable = [
        'user_id',
        'trust_level',
        'score',
        'last_promoted_at',
    ];

    protected $casts = [
        'last_promoted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
