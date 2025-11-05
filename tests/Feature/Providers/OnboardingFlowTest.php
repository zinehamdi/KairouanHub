<?php

namespace Tests\Feature\Providers;

use App\Models\ProviderProfile;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class OnboardingFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_complete_onboarding_flow_with_pending_status(): void
    {
        config(['appsettings.providers.auto_approve' => false]);
        // roles seeded in base TestCase
        $user = User::factory()->create();
        $this->actingAs($user);

        // Step 1: create profile
        $response = $this->post(route('provider.store'), [
            'display_name' => 'My Studio',
            'city' => 'Kairouan',
            'bio' => 'We do great work',
            'skills' => ['php','laravel'],
            'cities' => ['Kairouan','Sousse'],
            'social' => ['facebook' => 'https://facebook.com/test']
        ]);
        $response->assertRedirect(route('provider.services'));
        $this->assertDatabaseHas('provider_profiles',[ 'user_id' => $user->id, 'display_name' => 'My Studio', 'status' => 'pending']);

        $profile = ProviderProfile::where('user_id',$user->id)->first();

        // Step 2: attach services
        $services = Service::factory()->count(2)->create();
        $payload = [
            'services' => [
                ['id' => $services[0]->id, 'price_min' => 50, 'price_max' => 100],
                ['id' => $services[1]->id, 'price_min' => 70, 'price_max' => 150],
            ]
        ];
        $response2 = $this->post(route('provider.services.store'), $payload);
        $response2->assertRedirect(route('provider.photos'));
        $this->assertEquals(2, $profile->fresh()->services()->count());

        // Step 3: upload photos (limit 6 default) - we'll upload 2
        Storage::fake('public');
        $files = [
            UploadedFile::fake()->image('a.jpg'),
            UploadedFile::fake()->image('b.png'),
        ];
        $response3 = $this->post(route('provider.photos.store'), [
            'photos' => $files
        ]);
        $response3->assertRedirect(route('provider.dashboard'));
        $this->assertNotEmpty($profile->fresh()->photos_json);
    $this->assertTrue(Storage::disk('public')->exists($profile->fresh()->photos_json[0]));

        // Dashboard accessible
        $dash = $this->get(route('provider.dashboard'));
        $dash->assertOk();
        $dash->assertSee('My Studio');
    }

    public function test_auto_approved_skips_pending_logic(): void
    {
        config(['appsettings.providers.auto_approve' => true]);
        // roles seeded in base TestCase
        $user = User::factory()->create();
        $this->actingAs($user);
        $resp = $this->post(route('provider.store'), [
            'display_name' => 'Fast Provider',
            'city' => 'Tunis'
        ]);
        $resp->assertRedirect(route('provider.services'));
        $this->assertDatabaseHas('provider_profiles',[ 'user_id' => $user->id, 'status' => 'approved']);
    }

    public function test_cannot_access_steps_without_profile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get(route('provider.services'))->assertNotFound();
        $this->get(route('provider.photos'))->assertNotFound();
    }
}
