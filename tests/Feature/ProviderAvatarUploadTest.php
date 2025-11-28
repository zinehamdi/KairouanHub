<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ProviderProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class ProviderAvatarUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_provider_avatar_upload_converts_to_webp_and_saves()
    {
        Storage::fake('public');

        $user = User::factory()->create(['email_verified_at' => now()]);
        Role::firstOrCreate(['name' => 'client']); // role required for policies elsewhere
        $user->assignRole('client');

        $profile = ProviderProfile::create([
            'user_id' => $user->id,
            'category_id' => null,
            'display_name' => 'Tester',
            'city' => 'kairouan',
            'status' => 'approved'
        ]);

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('avatar.jpg', 800, 600);

        $response = $this->post(route('provider.avatar.update'), [
            'avatar' => $file,
        ]);

        $response->assertRedirect();

        $profile->refresh();
        $this->assertNotNull($profile->avatar, 'Avatar path should be set');
        $this->assertStringEndsWith('.webp', $profile->avatar, 'Avatar must be converted to webp');
        $this->assertTrue(Storage::disk('public')->exists($profile->avatar), 'Stored avatar file should exist');
    }
}
