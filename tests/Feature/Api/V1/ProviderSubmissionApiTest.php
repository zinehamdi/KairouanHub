<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProviderSubmissionApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_provider_and_is_pending(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $payload = [
            'provider_name' => 'Test Provider',
            'phone' => '+21612345678',
            'city' => 'Kairouan',
            'description' => 'Test description',
        ];

        $response = $this->postJson('/api/v1/providers/submissions', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('data.status', 'pending')
            ->assertJsonPath('data.provider_name', 'Test Provider');
    }

    public function test_duplicate_phone_submission_is_blocked(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $payload = [
            'provider_name' => 'Test Provider',
            'phone' => '+21687654321',
            'city' => 'Kairouan',
        ];

        $this->postJson('/api/v1/providers/submissions', $payload)->assertStatus(201);

        $duplicate = $this->postJson('/api/v1/providers/submissions', $payload);
        $duplicate->assertStatus(422)
            ->assertJsonPath('message', 'This phone is already submitted and under review.');
    }

    public function test_user_can_view_own_submission_history(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Create some submissions
        \App\Models\ProviderSubmission::factory()->count(3)->create(['user_id' => $user->id]);
        // Someone else's submission
        \App\Models\ProviderSubmission::factory()->create(['user_id' => User::factory()->create()->id]);

        $response = $this->getJson('/api/v1/me/submissions');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'provider_name', 'status']
                ],
                'meta' => ['pagination']
            ]);
    }
}
