<?php

namespace Tests\Feature\Api\V1;

use App\Models\JobRequest;
use App\Models\ProviderProfile;
use App\Models\User;
use App\Notifications\NewOfferNotification;
use App\Notifications\OfferAcceptedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NotificationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_notifications_sent_on_offer_and_acceptance(): void
    {
        Notification::fake();

        $client = User::factory()->create();
        $client->assignRole('client');
        $providerUser = User::factory()->create();
        $providerUser->assignRole('provider');
        ProviderProfile::factory()->approved()->create(['user_id' => $providerUser->id, 'status' => 'approved']);

        $job = JobRequest::factory()->create([
            'client_id' => $client->id,
            'status' => 'open',
        ]);

        Sanctum::actingAs($providerUser);
        $offerRes = $this->postJson("/api/v1/requests/{$job->id}/offers", [
            'price' => 150,
        ]);
        $offerRes->assertStatus(201);
        $offerId = $offerRes->json('data.id');

        Notification::assertSentTo($client, NewOfferNotification::class);

        Sanctum::actingAs($client);
        $acceptRes = $this->postJson("/api/v1/offers/{$offerId}/accept");
        $acceptRes->assertStatus(200);

        Notification::assertSentTo($providerUser, OfferAcceptedNotification::class);
    }
}
