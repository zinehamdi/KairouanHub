<?php

namespace Domain\Services\Repositories;

use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/** Service Repository Port — واجهة مستودع الخدمات */
interface ServiceRepository
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): ?Service;
    public function findBySlug(string $slug): ?Service;
    public function create(array $data): Service;
    public function update(Service $service, array $data): Service;
    public function delete(Service $service): void;
}
