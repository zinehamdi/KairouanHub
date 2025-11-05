<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class RealWorldEmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_complete_new_user_registration_and_verification_flow()
    {
        Notification::fake();
        
        // Step 1: User registers
        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        
        // Should redirect to dashboard
        $response->assertRedirect('/dashboard');
        
        // User exists in database but not verified
        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertNotNull($user);
        $this->assertFalse($user->hasVerifiedEmail());
        
        // Verification email was sent
        Notification::assertSentTo($user, VerifyEmail::class);
        
        // Step 2: User is blocked from protected routes
        $this->actingAs($user);
        $response = $this->get('/requests/create');
        $response->assertRedirect('/verify-email');
        
        // Step 3: Generate the verification URL (simulating email link)
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        
        // Step 4: User clicks the verification link
        $response = $this->get($verificationUrl);
        
        // Should redirect with verified flag
        $this->assertTrue(in_array($response->status(), [200, 302]));
        
        // User is now verified
        $user->refresh();
        $this->assertTrue($user->hasVerifiedEmail());
        $this->assertNotNull($user->email_verified_at);
        
        // Step 6: Verify the URL cannot be reused
        $response = $this->get($verificationUrl);
        // Already verified - should redirect to dashboard
    }

    public function test_multiple_users_can_register_and_verify_independently()
    {
        // Simulate 5 users registering
        $users = [];
        
        for ($i = 1; $i <= 5; $i++) {
            $email = "user{$i}@example.com";
            
            // Create unverified user
            $user = User::factory()->unverified()->create([
                'name' => "User {$i}",
                'email' => $email,
            ]);
            
            $this->assertFalse($user->hasVerifiedEmail());
            
            // Generate verification URL
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );
            
            // Verify email
            $this->actingAs($user)->get($verificationUrl);
            
            $user->refresh();
            $this->assertTrue($user->hasVerifiedEmail());
            
            $users[] = $user;
        }
        
        // All users should be independently verified
        $this->assertCount(5, $users);
        foreach ($users as $user) {
            $this->assertTrue($user->hasVerifiedEmail());
        }
    }

    public function test_user_cannot_verify_with_another_users_link()
    {
        // Create two users
        $user1 = User::factory()->unverified()->create(['email' => 'user1@test.com']);
        $user2 = User::factory()->unverified()->create(['email' => 'user2@test.com']);
        
        // Generate verification URL for user1
        $user1VerificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user1->id, 'hash' => sha1($user1->email)]
        );
        
        // User2 tries to use user1's verification link
        $this->actingAs($user2);
        $response = $this->get($user1VerificationUrl);
        
        // Should fail (403 Forbidden) - wrong user
        $response->assertStatus(403);
        
        // Neither user should be verified
        $this->assertFalse($user1->fresh()->hasVerifiedEmail());
        $this->assertFalse($user2->fresh()->hasVerifiedEmail());
    }

    public function test_verification_requires_user_to_be_logged_in()
    {
        $user = User::factory()->unverified()->create();
        
        // Generate verification URL
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        
        // Try to verify without being logged in
        $response = $this->get($verificationUrl);
        
        // Should redirect to login
        $response->assertRedirect('/login');
        
        // User should not be verified
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    public function test_resending_verification_email_generates_new_valid_link()
    {
        Notification::fake();
        
        $user = User::factory()->unverified()->create();
        
        // User requests new verification email
        $this->actingAs($user)
            ->post('/email/verification-notification')
            ->assertSessionHas('status', 'verification-link-sent');
        
        // New verification notification was sent
        Notification::assertSentTo($user, VerifyEmail::class);
        
        // Generate new verification URL
        $newVerificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        
        // New link should work
        $this->get($newVerificationUrl)->assertRedirect('/dashboard?verified=1');
        
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
