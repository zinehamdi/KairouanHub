<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\ProviderProfile;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use App\Notifications\NewJobRequestNotification;

class JobRequestNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_job_request_sends_notification_to_provider_user()
    {
        Notification::fake();

        $client = User::factory()->create(['email_verified_at' => now()]);
        $providerUser = User::factory()->create();

        $category = Category::create([
            'name' => 'Cleaning',
            'slug' => 'cleaning'
        ]);

        ProviderProfile::create([
            'user_id' => $providerUser->id,
            'category_id' => $category->id,
            'display_name' => 'Provider One',
            'city' => 'kairouan',
            'status' => 'approved'
        ]);

        // Ensure roles exist and assign client role
        Role::firstOrCreate(['name' => 'client']);
        $client->assignRole('client');

        $this->actingAs($client);

        $response = $this->post(route('requests.store'), [
            'category_id' => $category->id,
            'details' => 'Need car wash',
            'city' => 'kairouan'
        ]);

        $response->assertRedirect();

        Notification::assertSentTo(
            [$providerUser],
            NewJobRequestNotification::class
        );
    }
}
