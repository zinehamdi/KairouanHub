<?php

namespace Application\Services\UseCases;

use App\Models\Service;
use Domain\Services\Repositories\ServiceRepository;

class UpdateServiceHandler
{
    public function __construct(private ServiceRepository $repo) {}
    public function __invoke(Service $service, array $data)
    { return $this->repo->update($service, $data); }
}
