<?php

namespace Infrastructure\Persistence\Services;

use App\Models\Service;
use Domain\Services\Repositories\ServiceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/** Eloquent Service Repository — تنفيذ باستخدام إلوكونت */
class EloquentServiceRepository implements ServiceRepository
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    { return Service::with('category')->latest('id')->paginate($perPage); }

    public function findById(int $id): ?Service
    { return Service::find($id); }

    public function findBySlug(string $slug): ?Service
    { return Service::where('slug', $slug)->first(); }

    public function create(array $data): Service
    { return Service::create($data); }

    public function update(Service $service, array $data): Service
    { $service->update($data); return $service->refresh(); }

    public function delete(Service $service): void
    { $service->delete(); }
}
