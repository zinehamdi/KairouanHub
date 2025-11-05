<?php

namespace App\Policies;

use App\Models\Offer;
use App\Models\User;

/**
 * EN: Authorization rules for offers.
 * AR: صلاحيات عروض المزودين.
 */
class OfferPolicy
{
    public function create(User $user): bool
    {
        return $user->providerProfile && $user->providerProfile->status === 'approved';
    }

    public function view(User $user, Offer $offer): bool
    {
        if ($user->hasRole('admin')) return true;
        if ($offer->request->client_id === $user->id) return true;
        if ($user->providerProfile && $offer->provider_id === $user->providerProfile->id) return true;
        return false;
    }

    public function update(User $user, Offer $offer): bool
    {
        if ($user->hasRole('admin')) return true;
        return $offer->status === 'pending' && $user->providerProfile && $offer->provider_id === $user->providerProfile->id;
    }
}
