<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];

    /**
     * Provider profile relationship (one-to-one)
     * EN: A user may have one provider profile.
     * AR: يمكن للمستخدم أن يمتلك ملف مزود واحد.
     */
    public function providerProfile()
    {
        return $this->hasOne(ProviderProfile::class);
    }

    public function driverProfile()
    {
        return $this->hasOne(DriverProfile::class);
    }

    /** Client job requests */
    public function jobRequests()
    {
        return $this->hasMany(JobRequest::class, 'client_id');
    }

    /** Provider submissions/suggestions */
    public function providerSubmissions()
    {
        return $this->hasMany(ProviderSubmission::class);
    }

    /** Points transactions */
    public function points()
    {
        return $this->hasMany(PointsTransaction::class);
    }

    /** Trust score */
    public function trust()
    {
        return $this->hasOne(UserTrust::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
