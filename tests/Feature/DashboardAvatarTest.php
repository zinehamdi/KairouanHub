<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ProviderProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DashboardAvatarTest extends TestCase
{
    use RefreshDatabase;

    public function test_provider_dashboard_displays_avatar_using_accessor()
    {
        Storage::fake('public');

        // Create provider user
        $user = User::factory()->create();
        $user->assignRole('provider');

        // Create provider profile with avatar
        $profile = ProviderProfile::factory()->create([
            'user_id' => $user->id,
            'avatar' => 'providers/1/avatar/test-avatar.webp'
        ]);

        // Act
        $response = $this->actingAs($user)->get('/dashboard');

        // Assert
        $response->assertStatus(200);
        
        // Verify avatar_url is used in the view
        $response->assertSee($profile->avatar_url, false);
        
        // Verify the profile photo label and upload button are present
        $response->assertSee('Profile Photo');
        $response->assertSee('Upload New Photo');
    }

    public function test_provider_dashboard_displays_default_avatar_when_none_uploaded()
    {
        Storage::fake('public');

        // Create provider user without avatar
        $user = User::factory()->create();
        $user->assignRole('provider');

        $profile = ProviderProfile::factory()->create([
            'user_id' => $user->id,
            'avatar' => null
        ]);

        // Act
        $response = $this->actingAs($user)->get('/dashboard');

        // Assert
        $response->assertStatus(200);
        
        // Verify default avatar is used
        $response->assertSee('default-avatar.png');
        $response->assertSee($profile->avatar_url);
    }

    public function test_avatar_upload_form_is_present_on_provider_dashboard()
    {
        $user = User::factory()->create();
        $user->assignRole('provider');

        ProviderProfile::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        
        // Verify form elements are present
        $response->assertSee('Upload New Photo');
        $response->assertSee('provider/avatar', false);
        $response->assertSee('accept="image/jpeg,image/png,image/webp"', false);
        $response->assertSee('Profile Photo');
    }

    public function test_avatar_upload_converts_to_webp_and_displays_on_dashboard()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $user->assignRole('provider');

        $profile = ProviderProfile::factory()->create([
            'user_id' => $user->id,
        ]);

        // Upload a test image
        $file = UploadedFile::fake()->image('avatar.jpg', 500, 500);

        $response = $this->actingAs($user)
            ->post(route('provider.avatar.update'), [
                'avatar' => $file
            ]);

        // Verify redirect back
        $response->assertRedirect();

        // Refresh profile
        $profile->refresh();

        // Verify avatar path ends with .webp
        $this->assertNotNull($profile->avatar);
        $this->assertStringEndsWith('.webp', $profile->avatar);

        // Verify avatar_url returns the correct path
        $this->assertStringContainsString('storage/', $profile->avatar_url);
        $this->assertStringContainsString('.webp', $profile->avatar_url);

        // Verify dashboard displays the avatar
        $dashboardResponse = $this->actingAs($user)->get('/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee($profile->avatar_url);
    }
}
