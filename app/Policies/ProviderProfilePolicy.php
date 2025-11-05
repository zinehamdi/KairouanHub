<?php

namespace App\Policies;

use App\Models\ProviderProfile;
use App\Models\User;
use Domain\Providers\Enums\ProviderStatus;

/**
 * EN: Authorization logic for provider profiles.
 * AR: منطق التفويض لملفات المزود.
 */
class ProviderProfilePolicy
{
    /** View: public if approved; owner or admin always */
    public function view(?User $user, ProviderProfile $profile): bool
    {
        if($profile->status === ProviderStatus::Approved->value) return true;
        if(!$user) return false;
        return $user->id === $profile->user_id || $user->hasRole('admin');
    }

    /** Create: user authenticated and has no profile */
    public function create(User $user): bool
    {
        // Check if user already has a provider profile
        $existingProfile = ProviderProfile::where('user_id', $user->id)->first();
        return !$existingProfile;
    }

    /** Update: owner or admin */
    public function update(User $user, ProviderProfile $profile): bool
    {
        return $user->id === $profile->user_id || $user->hasRole('admin');
    }
}
