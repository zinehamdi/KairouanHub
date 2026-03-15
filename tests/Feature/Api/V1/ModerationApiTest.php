<?php

namespace Tests\Feature\Api\V1;

use App\Models\PointsTransaction;
use App\Models\ProviderProfile;
use App\Models\ProviderSubmission;
use App\Models\User;
use App\Models\UserTrust;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ModerationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_pending_submissions(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $user = User::factory()->create();

        $submission = ProviderSubmission::create([
            'user_id' => $user->id,
            'provider_name' => 'P1',
            'phone' => '+21610000000',
            'status' => 'pending',
        ]);

        Sanctum::actingAs($admin);

        $response = $this->getJson('/api/v1/admin/submissions?status=pending');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $submission->id]);
    }

    public function test_admin_can_approve_submission_creates_profile_points_and_trust(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $user = User::factory()->create();

        $submission = ProviderSubmission::create([
            'user_id' => $user->id,
            'provider_name' => 'Provider A',
            'phone' => '+21620000000',
            'status' => 'pending',
        ]);

        Sanctum::actingAs($admin);

        $response = $this->postJson("/api/v1/admin/submissions/{$submission->id}/approve");

        $response->assertStatus(201)
            ->assertJsonPath('data.phone', '+21620000000')
            ->assertJsonPath('data.name', 'Provider A');

        $this->assertDatabaseHas('provider_profiles', ['user_id' => $user->id, 'phone' => '+21620000000']);
        $this->assertDatabaseHas('points_transactions', ['user_id' => $user->id, 'points' => 50, 'type' => 'earn']);
        $trust = UserTrust::where('user_id', $user->id)->first();
        $this->assertNotNull($trust);
        $this->assertEquals(25, $trust->score);
    }

    public function test_admin_can_reject_submission_without_creating_profile(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $user = User::factory()->create();

        $submission = ProviderSubmission::create([
            'user_id' => $user->id,
            'provider_name' => 'Provider B',
            'phone' => '+21630000000',
            'status' => 'pending',
        ]);

        Sanctum::actingAs($admin);

        $response = $this->postJson("/api/v1/admin/submissions/{$submission->id}/reject", [
            'reason' => 'Incomplete info',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'rejected');

        $this->assertDatabaseMissing('provider_profiles', ['phone' => '+21630000000']);
        $trust = UserTrust::where('user_id', $user->id)->first();
        $this->assertTrue($trust === null || $trust->score === 0);
    }
}
