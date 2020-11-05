<?php

use App\Http\Controllers\CheckAttributeController;
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

Route::apiResources([
    'users' => UserController::class,
    'pharmacies' => PharmacyController::class,
    'check-attributes' => CheckAttributeController::class,
    'checks' => CheckController::class,
]);

Route::post('user-rating', [UserRatingController::class, 'show']);
//Route::get('user/create', [UserController::class, 'create']);
Route::get('create/user', 'App\Http\Controllers\UserController@create');
Route::resource('pharmacy-rating',PharmaciesRatingController::class)->only(['index', 'show']);
//Route::post('pharmacy-rating', [PharmacyController::class, 'show']);
//Route::get('/test', function() {
//    return  $pharmacy = App\Models\Pharmacy::all()->last();
//});
