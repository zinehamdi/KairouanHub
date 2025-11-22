<?php

namespace Infrastructure\Providers\Repositories;

use App\Models\ProviderProfile;
use Domain\Providers\Repositories\ProviderProfileRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * EN: Eloquent implementation of provider profile repository.
 * AR: تنفيذ Eloquent لمستودع ملفات المزود.
 */
class EloquentProviderProfileRepository implements ProviderProfileRepositoryInterface
{
    public function create(array $data): ProviderProfile
    {
        return ProviderProfile::create($data);
    }

    public function findById(int $id): ?ProviderProfile
    {
        return ProviderProfile::with(['user','services'])->find($id);
    }

    public function findByUsernameOrId(string|int $usernameOrId): ?ProviderProfile
    {
        if(is_numeric($usernameOrId)) {
            return $this->findById((int)$usernameOrId);
        }
        // Future: username column, for now treat as display_name slug-like attempt
        return ProviderProfile::with(['user','services'])
            ->where('display_name', $usernameOrId)
            ->first();
    }

    public function paginatePublic(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        // Filter out empty values to prevent issues with scopes (e.g. rating="" -> 0.0 -> excludes NULL)
        $filters = array_filter($filters, function($v) { return $v !== null && $v !== ''; });

        $q = ProviderProfile::query()->approved();
        $q->city($filters['city'] ?? null)
          ->badge($filters['badge'] ?? null)
          ->minRating(isset($filters['rating']) ? (float)$filters['rating'] : null)
          ->withService($filters['category'] ?? null)
          ->search($filters['q'] ?? null);

        return $q->latest()->paginate($perPage)->withQueryString();
    }

    public function findByUserId(int $userId): ?ProviderProfile
    {
        return ProviderProfile::where('user_id',$userId)->first();
    }

    public function findPublicByUsernameOrId(string|int $key): ?ProviderProfile
    {
        $query = ProviderProfile::with(['user','services'])->approved();
        if(is_numeric($key)) {
            return $query->find($key);
        }
        return $query->where('display_name', $key)->first();
    }

    public function paginateApproved(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        return $this->paginatePublic($filters, $perPage);
    }

    public function createForUser(int $userId, array $data): ProviderProfile
    {
        $data['user_id'] = $userId;
        return ProviderProfile::create($data);
    }

    public function update(ProviderProfile $profile, array $data): ProviderProfile
    {
        $profile->update($data);
        return $profile->refresh();
    }

    public function syncServices(ProviderProfile $profile, array $services): void
    {
        $sync = [];
        foreach ($services as $svc) {
            $min = $svc['price_min'] ?? null;
            $max = $svc['price_max'] ?? null;
            $sync[$svc['id']] = ['price_min'=>$min,'price_max'=>$max];
        }
        $profile->services()->sync($sync);
    }

    public function appendPhotos(ProviderProfile $profile, array $paths, int $max = 6): ProviderProfile
    {
        $existing = $profile->photos_json ?? [];
        foreach ($paths as $p) {
            if(count($existing) >= $max) break;
            if(!in_array($p, $existing)) $existing[] = $p;
        }
        $profile->update(['photos_json'=>$existing]);
        return $profile->refresh();
    }

    public function featured(int $limit = 8)
    {
        return ProviderProfile::approved()
            ->orderByDesc('avg_rating')
            ->latest()
            ->limit($limit)
            ->get();
    }
}
