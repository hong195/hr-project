<?php

namespace App\Providers;

use App\Models\Check;
use App\Observers\CheckObserver;
use App\Repositories\CheckAttributeRepository;
use App\Repositories\CheckRepository;
use App\Repositories\Contracts\CheckAttributeRepositoryContract;
use App\Repositories\Contracts\CheckRepositoryContract;
use App\Repositories\Contracts\RatingRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\PharmacyRepository;
use App\Repositories\RatingRepository;
use App\Repositories\UserRepository;
use App\Services\Contracts\CriteriaInterface;
use App\Services\CriteriaService;
use Carbon\Carbon;
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
        $this->app->singleton(CriteriaInterface::class, CriteriaService::class);
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(CheckAttributeRepositoryContract::class, CheckAttributeRepository::class);
        $this->app->bind(CheckRepositoryContract::class, CheckRepository::class);
        $this->app->bind(RatingRepositoryContract::class, RatingRepository::class);
        $this->app->bind(PharmacyRepository::class, PharmacyRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        Check::observe(CheckObserver::class);
    }
}
