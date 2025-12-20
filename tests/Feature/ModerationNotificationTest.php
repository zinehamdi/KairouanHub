<?php

namespace Tests\Feature;

use App\Models\ProviderSubmission;
use App\Models\User;
use App\Notifications\ProviderSubmissionProcessed;
use App\Services\ModerationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ModerationNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_notified_on_approval(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $submission = ProviderSubmission::create([
            'user_id' => $user->id,
            'provider_name' => 'Test Provider',
            'phone' => '+21612345678',
            'status' => 'pending',
        ]);

        $service = app(ModerationService::class);
        $service->approve($submission, $admin);

        Notification::assertSentTo(
            $user,
            ProviderSubmissionProcessed::class,
            function ($notification, $channels) use ($submission) {
                return $notification->toArray($submission->user)['status'] === 'approved' &&
                       $notification->toArray($submission->user)['submission_id'] === $submission->id;
            }
        );
    }

    public function test_user_is_notified_on_rejection(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $submission = ProviderSubmission::create([
            'user_id' => $user->id,
            'provider_name' => 'Test Provider',
            'phone' => '+21612345678',
            'status' => 'pending',
        ]);

        $service = app(ModerationService::class);
        $service->reject($submission, $admin, 'Duplicate entry');

        Notification::assertSentTo(
            $user,
            ProviderSubmissionProcessed::class,
            function ($notification, $channels) use ($submission) {
                return $notification->toArray($submission->user)['status'] === 'rejected' &&
                       $notification->toArray($submission->user)['submission_id'] === $submission->id;
            }
        );
    }
}
