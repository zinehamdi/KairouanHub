<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class EmailVerificationUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_verification_url_uses_correct_app_url()
    {
        // Set APP_URL
        Config::set('app.url', 'http://127.0.0.1:8002');
        
        $user = User::factory()->unverified()->create();
        
        // Generate verification URL (same way Laravel does it)
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        
        // Check that URL starts with APP_URL
        $this->assertStringStartsWith('http://127.0.0.1:8002', $verificationUrl);
        $this->assertStringContainsString('/verify-email/', $verificationUrl);
        $this->assertStringContainsString((string)$user->id, $verificationUrl);
        $this->assertStringContainsString('expires=', $verificationUrl);
        $this->assertStringContainsString('signature=', $verificationUrl);
    }

    public function test_verification_url_works_for_different_users()
    {
        Config::set('app.url', 'http://127.0.0.1:8002');
        
        // Create 3 different users
        $users = User::factory()->unverified()->count(3)->create();
        
        foreach ($users as $user) {
            // Generate verification URL for each user
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );
            
            // Extract components
            $this->assertStringContainsString((string)$user->id, $verificationUrl);
            $this->assertStringContainsString(sha1($user->email), $verificationUrl);
            
            // Each URL should be unique
            $this->assertNotEmpty($verificationUrl);
        }
    }

    public function test_verification_url_has_unique_hash_per_user_email()
    {
        $user1 = User::factory()->unverified()->create(['email' => 'user1@test.com']);
        $user2 = User::factory()->unverified()->create(['email' => 'user2@test.com']);
        
        $url1 = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user1->id, 'hash' => sha1($user1->email)]
        );
        
        $url2 = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user2->id, 'hash' => sha1($user2->email)]
        );
        
        // URLs should be different
        $this->assertNotEquals($url1, $url2);
        
        // Hashes should be different
        $this->assertNotEquals(sha1($user1->email), sha1($user2->email));
    }

    public function test_verification_url_cannot_be_used_for_different_user()
    {
        $user1 = User::factory()->unverified()->create();
        $user2 = User::factory()->unverified()->create();
        
        // Generate URL for user1
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user1->id, 'hash' => sha1($user1->email)]
        );
        
        // Try to use it as user2 (should fail)
        $this->actingAs($user2);
        $response = $this->get($verificationUrl);
        
        // Should not verify user2
        $this->assertFalse($user2->fresh()->hasVerifiedEmail());
        
        // User1 should also not be verified (different authenticated user)
        $this->assertFalse($user1->fresh()->hasVerifiedEmail());
    }

    public function test_verification_url_with_wrong_hash_fails()
    {
        $user = User::factory()->unverified()->create();
        
        // Create URL with wrong hash
        $wrongUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => 'wrong-hash-value']
        );
        
        $this->actingAs($user);
        $response = $this->get($wrongUrl);
        
        // User should not be verified
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    public function test_expired_verification_url_fails()
    {
        $user = User::factory()->unverified()->create();
        
        // Create URL that expired 1 minute ago
        $expiredUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->subMinute(),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        
        $this->actingAs($user);
        $response = $this->get($expiredUrl);
        
        // Should fail (403 or redirect)
        $this->assertNotEquals(200, $response->status());
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    public function test_verification_url_signature_prevents_tampering()
    {
        $user = User::factory()->unverified()->create();
        
        // Generate valid URL
        $validUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        
        // Tamper with the URL by changing user ID
        $tamperedUrl = str_replace(
            "/verify-email/{$user->id}/",
            "/verify-email/999/",
            $validUrl
        );
        
        $this->actingAs($user);
        $response = $this->get($tamperedUrl);
        
        // Should fail due to invalid signature
        $this->assertEquals(403, $response->status());
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}
