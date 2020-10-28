<?php

namespace App\Observers;

use App\Enums\CheckLimit;
use App\Models\Check;
use App\Services\RatingService;
use Illuminate\Support\Facades\Gate;

class CheckObserver
{
    public function created(Check $check)
    {
//        if (Gate::denies('create-rating', $check->created_at)) {
//            return;
//        }

        $user = $check->user;
        $created_at = $check->created_at;
        $checks = $user->checks()
            ->whereYear('created_at', $created_at->year)
            ->whereMonth('created_at', $created_at->month)
            ->get();

        if ($checks->count() === CheckLimit::MINIMUM_FOR_CREATING_RATING) {
            $ratingService = new RatingService($user, $created_at, $checks);
            $ratingService->createRating();

        }
    }
}
