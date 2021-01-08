<?php

namespace App\Providers;

use App\Models\Check;
use App\Observers\CheckObserver;
use App\Queries\CheckAttributesQueryInterface;
use App\Queries\CheckQueryInterface;
use App\Queries\Eloquent\CheckAttributesQuery;
use App\Queries\Eloquent\CheckQuery;
use App\Queries\Eloquent\PharmacyQuery;
use App\Queries\Eloquent\PharmacyRatingQuery;
use App\Queries\Eloquent\UserQuery;
use App\Queries\PharmacyQueryInterface;
use App\Queries\PharmacyRatingQueryInterface;
use App\Queries\UserQueryInterface;
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

        $this->app->bind(CheckQueryInterface::class, function () {
            $relations = request()->with ?? [];

            $query = new CheckQuery(
                request()->get('userId'),
                request()->get('name'),
                request()->get('year'),
                request()->get('month'),
                request()->get('ratingId')
            );

            $query->with($relations);

            return $query->setOrderBy(request()->get('orderBy', ''))->setDirection(request()->get('direction', ''));
        });

        $this->app->bind(PharmacyQueryInterface::class, function () {
            $query = new PharmacyQuery(
                request()->get('id'),
                request()->get('name'),
            );

            return $query->setOrderBy(request()->get('orderBy', ''))->setDirection(request()->get('direction', ''));
        });

        $this->app->bind(UserQueryInterface::class, function () {
            $query = new UserQuery(
                request()->get('userId'),
                request()->get('pharmacyId'),
                request()->get('name'),
                request()->get('ratingMonth'),
                request()->get('ratingYear'),
            );

            return $query->setOrderBy(request()->get('orderBy', ''))->setDirection(request()->get('direction', ''));
        });

        $this->app->bind(CheckAttributesQueryInterface::class, function () {
            $query = new CheckAttributesQuery(
                request()->get('label'),
                request()->get('name'),
                request()->get('type'),
                request()->get('used_in_rating', false),
            );
            return $query->setOrderBy(request()->get('orderBy', ''))->setDirection(request()->get('direction', ''));
        });

        $this->app->bind(PharmacyRatingQueryInterface::class, function () {
            $query = new PharmacyRatingQuery(
                request()->get('pharmacyId'),
                request()->get('year'),
                request()->get('month'),
            );
            return $query->setOrderBy(request()->get('orderBy', ''))->setDirection(request()->get('direction', ''));
        });
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
