<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->hasRole(User::ROLE_ADMIN);
        });

        Gate::define('moderator', function ($user) {
            return $user->hasRole(User::ROLE_MODERATOR);
        });

        Gate::define('seller', function ($user) {
            return $user->hasRole(User::ROLE_SELLER);
        });

        Gate::define('buyer', function ($user) {
            return $user->hasRole(User::ROLE_BUYER);
        });
    }
}