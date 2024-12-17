<?php

namespace App\Providers;

use App\Services\Connect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->singleton(Connect::class, fn() => new Connect());
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        $this->useDatabaseProtection();
        $this->useStrictModels();

        Vite::usePrefetchStrategy('aggressive');

    }

    private function useDatabaseProtection(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction(),
        );
    }

    private function useStrictModels(): void
    {
        Model::shouldBeStrict();
        Model::unguard();
    }
}
