<?php

namespace App\Providers;

use App\Models\Password;
use App\Models\User;
use App\Observers\PasswordObserver;
use App\Observers\UserObserver;
use Auth;
use DB;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Password::observe(PasswordObserver::class);

        // All view's
        View::share('version', env('APP_VERSION'));
        View::share('assets', 'assets' . (config('app.env') == 'local' ? '_dev' : ''));

        // Components
        \Blade::include('components.select', 'select');

        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    }
}
