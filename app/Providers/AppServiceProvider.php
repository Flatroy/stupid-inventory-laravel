<?php

namespace App\Providers;

use App\Models\User;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
        // needed to solve issue https://github.com/livewire/livewire/discussions/5923 - in future should be fixed by Livewire
        FilamentAsset::register([
            Js::make('custom-script', __DIR__.'/../../resources/js/custom.filament.js'),
        ]);

        // As these are concerned with application correctness,
        // leave them enabled all the time.
        Model::preventAccessingMissingAttributes(! $this->app->isProduction());
        Model::preventSilentlyDiscardingAttributes(! $this->app->isProduction());

        Model::preventLazyLoading(! $this->app->isProduction());

        Model::shouldBeStrict(! $this->app->isProduction());

        Gate::define('viewPulse', function (User $user) {
            return true; // $user->hasRole('super-admin') || app()->isLocal();
        });

        if ($this->app->isProduction()) {
            Model::handleLazyLoadingViolationUsing(function (
                $model,
                $relation
            ) {
                $class = get_class($model);

                info(
                    "Attempted to lazy load [{$relation}] on model [{$class}]."
                );
            });
        }
        /*if ($this->app->isProduction()) {
            $this->app['request']->server->set('HTTPS', true);
            \URL::forceScheme('https');
        }*/

        if ($this->app->isLocal() && ! $this->app->runningInConsole()) {
            DB::listen(function (QueryExecuted $event) {
                if ($event->time > 250) {
                    throw new QueryException(
                        'db',
                        $event->sql,
                        $event->bindings,
                        new \Exception('Individual database query exceeded '.$event->time.'ms.')
                    );
                }
            });

            DB::whenQueryingForLongerThan(2000, function (Connection $connection) {
                \Log::warning("Database queries exceeded 2 seconds on {$connection->getName()}");
            });

        }

    }
}
