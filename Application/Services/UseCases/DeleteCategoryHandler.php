<?php

namespace Application\Services\UseCases;

use App\Models\Category;
use Domain\Services\Repositories\CategoryRepository;

class DeleteCategoryHandler
{
    public function __construct(private CategoryRepository $repo) {}
    public function __invoke(Category $category): void
    { $this->repo->delete($category); }
}
