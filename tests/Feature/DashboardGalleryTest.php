<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ProviderProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardGalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_provider_dashboard_displays_gallery_photos()
    {
        // Create provider user with photos
        $user = User::factory()->create();
        $user->assignRole('provider');

        $photos = [
            'providers/1/gallery/photo1.webp',
            'providers/1/gallery/photo2.webp',
            'providers/1/gallery/photo3.webp'
        ];

        $profile = ProviderProfile::factory()->create([
            'user_id' => $user->id,
            'photos_json' => $photos
        ]);

        // Act
        $response = $this->actingAs($user)->get('/dashboard');

        // Assert
        $response->assertStatus(200);
        
        // Verify gallery tab shows photo count
        $response->assertSee('Gallery (' . count($photos) . ')');
        
        // Verify each photo is displayed with correct path
        foreach ($photos as $photo) {
            $response->assertSee('storage/' . $photo, false);
        }
    }

    public function test_provider_dashboard_shows_empty_gallery_state()
    {
        // Create provider without photos
        $user = User::factory()->create();
        $user->assignRole('provider');

        ProviderProfile::factory()->create([
            'user_id' => $user->id,
            'photos_json' => null
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Gallery (0)');
        $response->assertSee('No gallery photos yet');
        $response->assertSee('Upload Photos');
    }

    public function test_provider_can_access_photo_upload_from_dashboard()
    {
        $user = User::factory()->create();
        $user->assignRole('provider');

        ProviderProfile::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        // Verify link to photo management page exists
        $response->assertSee(route('provider.photos'), false);
    }
}
