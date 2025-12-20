<?php

namespace Tests\Feature\Api\V1;

use App\Models\Category;
use App\Models\JobRequest;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class JobRequestsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_and_view_job_request(): void
    {
        $user = User::factory()->create();
        $user->assignRole('client');
        Sanctum::actingAs($user);

        $category = Category::factory()->create();
        $service = Service::factory()->create(['category_id' => $category->id]);

        $payload = [
            'category_id' => $category->id,
            'service_id' => $service->id,
            'details' => 'Fix sink',
            'city' => 'Kairouan',
        ];

        $create = $this->postJson('/api/v1/requests', $payload);
        $create->assertStatus(201)
            ->assertJsonPath('data.status', 'open');

        $jobId = $create->json('data.id');

        $browse = $this->getJson('/api/v1/requests');
        $browse->assertStatus(200)
            ->assertJsonFragment(['id' => $jobId]);

        $mine = $this->getJson('/api/v1/my/requests');
        $mine->assertStatus(200)
            ->assertJsonFragment(['id' => $jobId]);
    }
}
