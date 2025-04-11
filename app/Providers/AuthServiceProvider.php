<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Gate::define('admin', function($user) {
            return $user->role == 'admin';
        });

        Gate::define('tasker', function($user) {
            return $user->role == 'tasker';
        });

        Gate::define('worker', function($user) {
            return $user->role == 'worker';
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
