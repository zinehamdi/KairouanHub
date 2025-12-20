<?php

namespace App\Services;

use App\Models\ModerationLog;
use App\Models\ProviderProfile;
use App\Models\ProviderSubmission;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\ProviderSubmissionProcessed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use RuntimeException;

class ModerationService
{
    private const APPROVAL_POINTS = 50;
    private const APPROVAL_TRUST = 25;
    private const REJECTION_TRUST = -5;

    public function __construct(
        private PointsService $pointsService,
        private TrustService $trustService,
    ) {
    }

    public function approve(ProviderSubmission $submission, User $moderator): ProviderProfile
    {
        if ($submission->status !== 'pending') {
            throw new RuntimeException('Submission has already been reviewed.');
        }

        $normalizedPhone = $submission->phone;

        return DB::transaction(function () use ($submission, $moderator, $normalizedPhone) {
            $before = $submission->replicate();

            $submission->fill([
                'status' => 'approved',
                'reviewed_by' => $moderator->id,
                'reviewed_at' => Carbon::now(),
                'rejection_reason' => null,
            ]);
            $submission->save();

            $profile = ProviderProfile::firstOrCreate(
                ['user_id' => $submission->user_id],
                [
                    'phone' => $normalizedPhone,
                    'category_id' => $submission->category_id,
                    'display_name' => $submission->provider_name,
                    'city' => $submission->city ?? 'Unknown',
                    'bio' => $submission->description,
                    'status' => 'approved',
                    'badge_level' => 'none',
                ]
            );

            if (!$profile->wasRecentlyCreated) {
                $updates = [];
                if (!$profile->phone && $normalizedPhone) {
                    $updates['phone'] = $normalizedPhone;
                }
                if ($profile->status !== 'approved') {
                    $updates['status'] = 'approved';
                }
                if ($profile->badge_level === null) {
                    $updates['badge_level'] = 'none';
                }
                if ($updates) {
                    $profile->fill($updates);
                    $profile->save();
                }
            }

            $this->trustService->adjustScore($submission->user, self::APPROVAL_TRUST);
            $this->pointsService->award(
                $submission->user,
                self::APPROVAL_POINTS,
                'provider_submission.approved',
                $submission,
                ['moderator_id' => $moderator->id]
            );

            // Notify user
            $submission->user->notify(new ProviderSubmissionProcessed(
                $submission,
                'approved',
                self::APPROVAL_POINTS,
                self::APPROVAL_TRUST
            ));

            ModerationLog::create([
                'actor_id' => $moderator->id,
                'action' => 'provider_submission.approved',
                'target_type' => $submission->getMorphClass(),
                'target_id' => $submission->getKey(),
                'notes' => null,
                'old_values' => $before->toArray(),
                'new_values' => $submission->toArray(),
            ]);

            return $profile;
        });
    }

    public function reject(ProviderSubmission $submission, User $moderator, string $reason): ProviderSubmission
    {
        if ($submission->status !== 'pending') {
            throw new RuntimeException('Submission has already been reviewed.');
        }

        return DB::transaction(function () use ($submission, $moderator, $reason) {
            $before = $submission->replicate();

            $submission->fill([
                'status' => 'rejected',
                'reviewed_by' => $moderator->id,
                'reviewed_at' => Carbon::now(),
                'rejection_reason' => $reason,
            ]);
            $submission->save();

            $this->trustService->adjustScore($submission->user, self::REJECTION_TRUST);

            // Notify user
            $submission->user->notify(new ProviderSubmissionProcessed(
                $submission,
                'rejected',
                0,
                self::REJECTION_TRUST
            ));

            ModerationLog::create([
                'actor_id' => $moderator->id,
                'action' => 'provider_submission.rejected',
                'target_type' => $submission->getMorphClass(),
                'target_id' => $submission->getKey(),
                'notes' => $reason,
                'old_values' => $before->toArray(),
                'new_values' => $submission->toArray(),
            ]);

            return $submission;
        });
    }
}
