<?php

namespace Application\Services\UseCases;

use App\Models\Category;
use Domain\Services\Repositories\CategoryRepository;

class UpdateCategoryHandler
{
    public function __construct(private CategoryRepository $repo) {}
    public function __invoke(Category $category, array $data)
    { return $this->repo->update($category, $data); }
}
