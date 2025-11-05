<?php

namespace Domain\Services\Repositories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/** Category Repository Port — واجهة مستودع التصنيفات */
interface CategoryRepository
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): ?Category;
    public function findBySlug(string $slug): ?Category;
    public function create(array $data): Category;
    public function update(Category $category, array $data): Category;
    public function delete(Category $category): void;
}
