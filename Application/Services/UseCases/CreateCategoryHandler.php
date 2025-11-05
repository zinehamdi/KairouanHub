<?php

namespace Application\Services\UseCases;

use Domain\Services\Repositories\CategoryRepository;

/** Create Category UC — حالة استخدام إنشاء تصنيف */
class CreateCategoryHandler
{
    public function __construct(private CategoryRepository $repo) {}
    public function __invoke(array $data)
    { return $this->repo->create($data); }
}
