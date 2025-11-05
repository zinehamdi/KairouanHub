<?php

namespace Infrastructure\Persistence\Services;

use App\Models\Category;
use Domain\Services\Repositories\CategoryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/** Eloquent Category Repository — تنفيذ باستخدام إلوكونت */
class EloquentCategoryRepository implements CategoryRepository
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    { return Category::orderBy('position')->paginate($perPage); }

    public function findById(int $id): ?Category
    { return Category::find($id); }

    public function findBySlug(string $slug): ?Category
    { return Category::where('slug', $slug)->first(); }

    public function create(array $data): Category
    { return Category::create($data); }

    public function update(Category $category, array $data): Category
    { $category->update($data); return $category->refresh(); }

    public function delete(Category $category): void
    { $category->delete(); }
}
