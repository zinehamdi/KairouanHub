<?php

namespace Domain\Providers\Repositories;

use App\Models\ProviderProfile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * EN: Contract for provider profile persistence & queries.
 * AR: واجهة لاستعلامات وحفظ ملفات المزود.
 */
interface ProviderProfileRepositoryInterface
{
    public function create(array $data): ProviderProfile;
    public function findById(int $id): ?ProviderProfile;
    public function findByUsernameOrId(string|int $usernameOrId): ?ProviderProfile;
    public function findByUserId(int $userId): ?ProviderProfile;
    public function findPublicByUsernameOrId(string|int $key): ?ProviderProfile;
    public function paginateApproved(array $filters, int $perPage = 12): LengthAwarePaginator;
    public function createForUser(int $userId, array $data): ProviderProfile;
    public function update(ProviderProfile $profile, array $data): ProviderProfile;
    /** @param array<int,array{id:int,price_min?:int,price_max?:int}> $services */
    public function syncServices(ProviderProfile $profile, array $services): void;
    /** @param string[] $paths */
    public function appendPhotos(ProviderProfile $profile, array $paths, int $max = 6): ProviderProfile;
    public function featured(int $limit = 8);
}
