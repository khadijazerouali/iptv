<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Automatically finding the Policies
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            return 'App\\Policies\\' . class_basename($modelClass) . 'Policy';
        });

        // Register policies
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permission checks using can()
        Gate::before(function ($user, $ability) {
            // Make sure the method exists in the User model
            if ($user && $user->isSuperAdmin()) {
                return true;
            }
        });
    }
}
