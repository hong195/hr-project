<?php

namespace App\Http\Controllers;

use App\Http\Resources\RatingResource;
use App\Models\Rating;

class RatingsController extends Controller
{
    public function show($id)
    {
        $rating = Rating::find($id)->loadMissing('checks.reviewer');

        return new RatingResource($rating);
    }
}
