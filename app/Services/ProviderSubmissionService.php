<?php

namespace App\Services;

use App\Models\ProviderProfile;
use App\Models\ProviderSubmission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ProviderSubmissionService
{
    public function __construct(private TrustService $trustService)
    {
    }

    public function create(array $data, User $user): ProviderSubmission
    {
        if (!$this->trustService->canSubmit($user)) {
            throw new RuntimeException('Submission limit reached for your trust level.');
        }

        $normalizedPhone = $this->normalizePhone($data['phone'] ?? '');
        if ($normalizedPhone === '') {
            throw new RuntimeException('A valid phone number is required.');
        }

        // Block duplicates against existing providers
        $existsProvider = ProviderProfile::where('phone', $normalizedPhone)->exists();
        if ($existsProvider) {
            throw new RuntimeException('A provider with this phone already exists.');
        }

        // Block duplicates against pending/approved submissions with same phone
        $existsSubmission = ProviderSubmission::whereIn('status', ['pending', 'approved'])
            ->where('phone', $normalizedPhone)
            ->exists();
        if ($existsSubmission) {
            throw new RuntimeException('This phone is already submitted and under review.');
        }

        return DB::transaction(function () use ($data, $user, $normalizedPhone) {
            return ProviderSubmission::create([
                'user_id' => $user->id,
                'provider_name' => $data['provider_name'],
                'phone' => $normalizedPhone,
                'category_id' => $data['category_id'] ?? null,
                'city' => $data['city'] ?? null,
                'description' => $data['description'] ?? null,
                'status' => 'pending',
                'meta' => $data['meta'] ?? null,
            ]);
        });
    }

    public function listMine(User $user, int $perPage = 15)
    {
        return ProviderSubmission::where('user_id', $user->id)
            ->latest()
            ->paginate($perPage);
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);
        if (!$digits) {
            return '';
        }
        if (!str_starts_with($digits, '0') && !str_starts_with($digits, '216')) {
            // assume Tunisia if missing country code
            $digits = '216' . $digits;
        }
        return '+' . ltrim($digits, '+');
    }
}
