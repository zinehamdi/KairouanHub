<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class RegistrationVerificationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_requires_email_verification(): void
    {
        // User implements MustVerifyEmail interface
        $user = User::factory()->create(['email_verified_at' => null]);
        $this->assertFalse($user->hasVerifiedEmail());
    }

    public function test_new_user_is_redirected_to_dashboard_after_registration(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    public function test_verified_middleware_blocks_unverified_users(): void
    {
        $user = User::factory()->unverified()->create();
        
        // Try to access a verified-only route
        $response = $this->actingAs($user)->get('/requests/create');
        
        // Should redirect to verification notice
        $response->assertRedirect('/verify-email');
    }

    public function test_verified_users_can_access_protected_routes(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->assignRole('client');
        
        $response = $this->actingAs($user)->get('/requests/create');
        
        $response->assertOk();
    }

    public function test_verification_email_is_sent_on_registration(): void
    {
        Notification::fake();

        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'test@example.com')->first();
        
        // Verification email should be queued
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_user_can_request_new_verification_email(): void
    {
        Notification::fake();
        
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)
            ->post('/email/verification-notification');

        $response->assertRedirect();
        $response->assertSessionHas('status', 'verification-link-sent');
        
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_email_can_be_verified_with_valid_link(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertRedirect('/dashboard?verified=1');
    }

    public function test_already_verified_user_redirects_to_dashboard(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        // Already verified users get redirected with verified=1 query param
        $response->assertRedirect('/dashboard?verified=1');
    }

    public function test_verification_fails_with_invalid_signature(): void
    {
        $user = User::factory()->unverified()->create();

        // Create URL without proper signature
        $verificationUrl = route('verification.verify', [
            'id' => $user->id,
            'hash' => sha1($user->email)
        ]);

        $response = $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
        $response->assertStatus(403); // Forbidden
    }

    public function test_verification_fails_with_wrong_hash(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong@email.com')]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
        $response->assertStatus(403); // Forbidden
    }
}
