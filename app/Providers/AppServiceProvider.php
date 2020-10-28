<?php

namespace App\Providers;

use App\Models\Check;
use App\Models\User;
use App\Observers\CheckObserver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Check::observe(CheckObserver::class);

        Gate::define('create-rating', function (User $user, $created_at) {

            $created_at = $created_at instanceof Carbon ? $created_at : Carbon::parse($created_at);

            return $user->ratings()
                ->whereYear('created_at', $created_at->year)
                ->whereMonth('created_at', $created_at->month)
                ->exists();
        });
    }
}
