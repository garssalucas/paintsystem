<?php

namespace App\Providers;

use App\Models\Oryon;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('is-admin', function (User $user): bool {
            return $user->isAdmin();
        });

        // Gate::define('promocao', function (Oryon $produto, object $register): bool {
        //     return $produto->id === $register->produto_id;
        // });
    }
}
