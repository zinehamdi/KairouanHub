<?php

namespace App\Services;

use App\Models\JobRequest;
use App\Models\Offer;
use App\Models\User;
use App\Notifications\NewOfferNotification;
use App\Notifications\OfferAcceptedNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use RuntimeException;

class OfferService
{
    public function create(JobRequest $job, User $user, array $data): Offer
    {
        $profile = $user->providerProfile;
        if (!$profile) {
            throw new RuntimeException('Provider profile required.');
        }

        Gate::authorize('create', Offer::class);
        Gate::authorize('view', $job);

        if ($job->status !== 'open') {
            throw new RuntimeException('Cannot offer on a non-open request.');
        }

        if (Offer::where('request_id', $job->id)->where('provider_id', $profile->id)->exists()) {
            throw new RuntimeException('You have already submitted an offer.');
        }

        $offer = Offer::create([
            'request_id' => $job->id,
            'provider_id' => $profile->id,
            'note' => $data['note'] ?? null,
            'eta_days' => $data['eta_days'] ?? null,
            'price' => $data['price'] ?? null,
            'status' => 'pending',
        ]);

        Notification::send($job->client, new NewOfferNotification($offer));

        return $offer;
    }

    public function accept(Offer $offer, User $user): Offer
    {
        $job = $offer->request;

        if ($job->client_id !== $user->id) {
            throw new RuntimeException('Only the request owner can accept an offer.');
        }

        if ($job->status !== 'open') {
            throw new RuntimeException('Request is not open.');
        }

        if ($offer->provider && $offer->provider->user_id === $user->id) {
            throw new RuntimeException('Providers cannot accept their own offers.');
        }

        $offer->update(['status' => 'accepted']);
        Offer::where('request_id', $job->id)->where('id', '!=', $offer->id)->update(['status' => 'rejected']);
        $job->update(['status' => 'matched']);

        if ($offer->provider && $offer->provider->user) {
            Notification::send($offer->provider->user, new OfferAcceptedNotification($offer));
        }

        return $offer->fresh(['request', 'provider']);
    }
}
