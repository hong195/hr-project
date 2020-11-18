<?php

use App\Http\Controllers\CheckAttributeController;
use App\Http\Controllers\CheckAttributeOptionController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\PharmaciesRatingController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\UserController;
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
        'users' => UserController::class,
        'pharmacies' => PharmacyController::class,
        'check-attributes' => CheckAttributeController::class,
        'checks' => CheckController::class,
        'check-attribute-option' => CheckAttributeOptionController::class,
    ]);
});

Route::get('/roles', 'App\Http\Controllers\RoleController@index');

Route::post('user-rating', [UserRatingController::class, 'show']);
Route::get('user-rating', [UserRatingController::class, 'index']);

Route::resource('pharmacy-rating',PharmaciesRatingController::class)->only(['index', 'show']);
