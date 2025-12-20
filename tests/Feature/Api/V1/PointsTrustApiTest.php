<?php

namespace Tests\Feature\Api\V1;

use App\Models\PointsTransaction;
use App\Models\User;
use App\Services\TrustService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PointsTrustApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_points_balance_and_transactions_visible(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        PointsTransaction::create([
            'user_id' => $user->id,
            'type' => 'earn',
            'points' => 100,
            'reason' => 'test_award',
        ]);

        PointsTransaction::create([
            'user_id' => $user->id,
            'type' => 'spend',
            'points' => 40,
            'reason' => 'test_spend',
        ]);

        $res = $this->getJson('/api/v1/me/points');
        $res->assertStatus(200)
            ->assertJsonPath('data.balance', 60)
            ->assertJsonCount(2, 'data.transactions');
    }

    public function test_trust_level_and_limits_visible(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $trustService = app(TrustService::class);
        $trustService->adjustScore($user, 150);

        $res = $this->getJson('/api/v1/me/trust');
        $res->assertStatus(200)
            ->assertJsonPath('data.score', 150)
            ->assertJsonPath('data.trust_level', 'contributor')
            ->assertJsonStructure(['data' => ['limits' => ['submissions_per_hour']]]);
    }
}
