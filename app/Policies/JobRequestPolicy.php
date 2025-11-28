<?php

namespace App\Policies;

use App\Models\JobRequest;
use App\Models\User;

/**
 * EN: Authorization rules for job requests.
 * AR: صلاحيات طلبات الخدمات.
 */
class JobRequestPolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole('client');
    }

    public function view(User $user, JobRequest $request): bool
    {
        if ($user->hasRole('admin')) return true;
        if ($request->client_id === $user->id) return true;
        // provider who submitted an offer OR approved provider in same city for open requests
        if ($user->providerProfile) {
            $profile = $user->providerProfile;
            if ($request->offers()->where('provider_id', $profile->id)->exists()) return true;
            if ($profile->status === 'approved' && $request->status === 'open') return true;
        }
        return false;
    }

    public function update(User $user, JobRequest $request): bool
    {
        if ($user->hasRole('admin')) return true;
        return $request->status === 'open' && $request->client_id === $user->id;
    }
}
