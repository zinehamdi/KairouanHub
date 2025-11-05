<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Category;
use App\Models\Service;
use App\Policies\CategoryPolicy;
use App\Policies\ServicePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Service::class => ServicePolicy::class,
    \App\Models\ProviderProfile::class => \App\Policies\ProviderProfilePolicy::class,
    \App\Models\JobRequest::class => \App\Policies\JobRequestPolicy::class,
    \App\Models\Offer::class => \App\Policies\OfferPolicy::class,
    ];
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Grant all permissions to admin role
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}
