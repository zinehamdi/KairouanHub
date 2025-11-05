<?php

namespace Application\Providers\UseCases;

use App\Models\ProviderProfile;
use App\Models\User;
use Domain\Providers\Enums\ProviderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

/**
 * CreateProviderProfileHandler
 * EN: Creates a provider profile for a user (if none exists). Auto-approves based on config.
 * AR: ينشئ ملف مزود للمستخدم (إن لم يكن موجوداً). يمكن قبوله تلقائياً حسب الإعداد.
 */
class CreateProviderProfileHandler
{
    /**
     * @param array{user_id:int,display_name:string,city:string,bio?:string,website?:string,skills?:array,cities?:array} $data
     */
    public function handle(array $data): ProviderProfile
    {
        $user = User::findOrFail($data['user_id']);
        if ($user->providerProfile) {
            throw new InvalidArgumentException('Provider profile already exists for user');
        }

        $status = Config::get('appsettings.providers.auto_approve')
            ? ProviderStatus::Approved->value
            : ProviderStatus::Pending->value;

        return DB::transaction(function () use ($data, $status) {
            return ProviderProfile::create([
                'user_id' => $data['user_id'],
                'display_name' => $data['display_name'],
                'city' => $data['city'],
                'bio' => $data['bio'] ?? null,
                'website' => $data['website'] ?? null,
                'skills_json' => $data['skills'] ?? null,
                'cities_json' => $data['cities'] ?? null,
                'status' => $status,
            ]);
        });
    }
}
