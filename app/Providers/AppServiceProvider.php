<?php

namespace App\Providers;

use App\Extensions\EloquentWithTrashedUserProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        Password::defaults(function () {
            return Password::min(8)->max(72);
        });

        Blade::directive('date', function (string $expression) {
            return "<?php echo ($expression)->format('d.m.Y'); ?>";
        });

        Auth::provider('eloquentWithTrashed', function (Application $app, array $config) {
            return new EloquentWithTrashedUserProvider($app->make(Hasher::class), $config['model']);
        });
    }
}
