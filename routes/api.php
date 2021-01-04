<?php

use App\Http\Controllers\CheckAttributesController;
use App\Http\Controllers\CheckAttributeOptionController;
use App\Http\Controllers\ChecksController;
use App\Http\Controllers\PharmaciesRatingController;
use App\Http\Controllers\PharmaciesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserRatingController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => 'App\Http\Controllers\Auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::resources([
        'users' => UsersController::class,
        'pharmacies' => PharmaciesController::class,
        'check-attributes' => CheckAttributesController::class,
        'checks' => ChecksController::class,
        'check-attribute-option' => CheckAttributeOptionController::class,
    ]);
    Route::resource('pharmacy-rating',PharmaciesRatingController::class)->only(['index']);
    Route::resource('user-rating', UserRatingController::class)->only(['index']);
    Route::resource('roles', RolesController::class)->only(['index']);
});

