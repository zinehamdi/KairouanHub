<?php

namespace Application\Services\UseCases;

use Domain\Services\Repositories\ServiceRepository;

class CreateServiceHandler
{
    public function __construct(private ServiceRepository $repo) {}
    public function __invoke(array $data)
    { return $this->repo->create($data); }
}
