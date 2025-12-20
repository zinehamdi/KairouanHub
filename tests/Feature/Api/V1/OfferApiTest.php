<?php

namespace Tests\Feature\Api\V1;

use App\Models\JobRequest;
use App\Models\ProviderProfile;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OfferApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_provider_can_submit_offer_and_owner_can_accept(): void
    {
        $client = User::factory()->create();
        $client->assignRole('client');
        $providerUser = User::factory()->create();
        $providerUser->assignRole('provider');

        $providerProfile = ProviderProfile::factory()->approved()->create([
            'user_id' => $providerUser->id,
            'status' => 'approved',
        ]);

        $job = JobRequest::factory()->create([
            'client_id' => $client->id,
            'status' => 'open',
        ]);

        Sanctum::actingAs($providerUser);
        $offerRes = $this->postJson("/api/v1/requests/{$job->id}/offers", [
            'note' => 'Can do it',
            'price' => 100,
            'eta_days' => 2,
        ]);
        $offerRes->assertStatus(201);
        $offerId = $offerRes->json('data.id');

        Sanctum::actingAs($client);
        $acceptRes = $this->postJson("/api/v1/offers/{$offerId}/accept");
        $acceptRes->assertStatus(200)
            ->assertJsonPath('data.status', 'accepted');

        $this->assertDatabaseHas('job_requests', ['id' => $job->id, 'status' => 'matched']);
    }

    public function test_non_owner_cannot_accept_offer(): void
    {
        $client = User::factory()->create();
        $client->assignRole('client');
        $otherUser = User::factory()->create();
        $otherUser->assignRole('client');

        $providerUser = User::factory()->create();
        $providerUser->assignRole('provider');
        ProviderProfile::factory()->approved()->create([
            'user_id' => $providerUser->id,
            'status' => 'approved',
        ]);

        $job = JobRequest::factory()->create([
            'client_id' => $client->id,
            'status' => 'open',
        ]);

        Sanctum::actingAs($providerUser);
        $offerRes = $this->postJson("/api/v1/requests/{$job->id}/offers", [
            'price' => 120,
        ]);
        $offerId = $offerRes->json('data.id');

        Sanctum::actingAs($otherUser);
        $rejectAttempt = $this->postJson("/api/v1/offers/{$offerId}/accept");
        $rejectAttempt->assertStatus(400)
            ->assertJsonPath('message', 'Only the request owner can accept an offer.');
    }
}
