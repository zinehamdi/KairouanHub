<?php

namespace Tests\Feature\Requests;

use App\Models\Category;
use App\Models\JobRequest;
use App\Models\ProviderProfile;
use App\Models\Service;
use App\Models\User;
use App\Notifications\NewJobRequestNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateJobRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_create(): void
    {
        $this->get(route('requests.create'))->assertRedirect('/login');
    }

    public function test_client_can_create_request_with_photos(): void
    {
        Notification::fake();
        Storage::fake('public');
        $client = User::factory()->create();
        $client->assignRole('client');
        $category = Category::factory()->create();
        $service = Service::factory()->create(['category_id' => $category->id]);
        // Approved provider in same city who offers this service to receive notification
        $providerUser = User::factory()->create();
        $providerUser->assignRole('provider');
        $profile = ProviderProfile::factory()->approved()->create(['user_id'=>$providerUser->id,'city'=>'Kairouan']);
        // Attach the service to provider
        $profile->services()->attach($service->id, ['price_min' => 50, 'price_max' => 100]);

        $response = $this->actingAs($client)->post(route('requests.store'), [
            'category_id' => $category->id,
            'service_id' => $service->id,
            'city' => 'Kairouan',
            'details' => 'Need help with test service',
            'photos' => [UploadedFile::fake()->image('a.jpg'), UploadedFile::fake()->image('b.png')]
        ]);

        $response->assertRedirect();
        $jr = JobRequest::first();
        $this->assertNotNull($jr);
        $this->assertEquals('open', $jr->status);
        $this->assertCount(2, $jr->photos_json);
        foreach ($jr->photos_json as $p) {
            $this->assertStringContainsString('requests/'.$client->id, $p);
        }
        
        // Assert notification sent to matching provider
        Notification::assertSentTo($profile, NewJobRequestNotification::class);
    }
}
