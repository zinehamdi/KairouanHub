<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domain\Providers\Repositories\ProviderProfileRepositoryInterface;
use Infrastructure\Providers\Repositories\EloquentProviderProfileRepository;
use Domain\Services\Repositories\CategoryRepository;
use Domain\Services\Repositories\ServiceRepository;
use Infrastructure\Persistence\Services\EloquentCategoryRepository;
use Infrastructure\Persistence\Services\EloquentServiceRepository;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->bind(ServiceRepository::class, EloquentServiceRepository::class);
        $this->app->bind(ProviderProfileRepositoryInterface::class, EloquentProviderProfileRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enforce HTTPS in production
        if (config('app.env') === 'production' || config('app.force_https', false)) {
            URL::forceScheme('https');
        }
    }
}
