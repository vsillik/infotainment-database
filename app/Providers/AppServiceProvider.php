<?php

namespace App\Providers;

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
    }
}
