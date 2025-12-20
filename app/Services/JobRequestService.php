<?php

namespace App\Services;

use App\Infrastructure\Http\Requests\Jobs\StoreJobRequestRequest;
use App\Models\JobRequest;
use App\Models\ProviderProfile;
use App\Models\User;
use App\Notifications\NewJobRequestNotification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class JobRequestService
{
    public function create(array $data, User $user): JobRequest
    {
        Gate::authorize('create', JobRequest::class);

        if (!empty($data['provider_id']) && !empty($data['service_id'])) {
            $provider = ProviderProfile::find($data['provider_id']);
            if ($provider && !$provider->services()->where('service_id', $data['service_id'])->exists()) {
                abort(400, 'Selected provider does not offer this service.');
            }
        }

        $job = JobRequest::create([
            'client_id' => $user->id,
            'category_id' => $data['category_id'],
            'service_id' => $data['service_id'] ?? null,
            'provider_id' => $data['provider_id'] ?? null,
            'details' => $data['details'],
            'photos_json' => $data['photos'] ?? [],
            'city' => $data['city'],
            'scheduled_date' => $data['scheduled_date'] ?? null,
            'status' => 'open',
        ]);

        $providers = ProviderProfile::query()
            ->with('user')
            ->where('status', 'approved')
            ->where('city', $job->city)
            ->when($job->service_id, function ($q) use ($job) {
                $q->whereHas('services', fn($sq) => $sq->where('service_id', $job->service_id));
            })
            ->get();

        $users = $providers->pluck('user')->filter()->unique('id');
        if ($users->isNotEmpty()) {
            Notification::send($users, new NewJobRequestNotification($job));
        }

        return $job;
    }

    public function listOpen(User $user, array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = JobRequest::with(['category', 'service'])
            ->where('status', 'open')
            ->latest();

        if (!empty($filters['city'])) {
            $query->where('city', $filters['city']);
        } elseif ($user->providerProfile) {
            $city = $user->providerProfile->city;
            if ($city) {
                $query->where('city', $city);
            }
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['service_id'])) {
            $query->where('service_id', $filters['service_id']);
        }

        return $query->paginate($perPage);
    }

    public function listMine(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return JobRequest::where('client_id', $user->id)
            ->with(['category', 'service', 'provider'])
            ->latest()
            ->paginate($perPage);
    }

    public function findForUser(User $user, int $id): JobRequest
    {
        $job = JobRequest::with(['category', 'service', 'provider'])
            ->findOrFail($id);

        Gate::authorize('view', $job);

        return $job;
    }
}
