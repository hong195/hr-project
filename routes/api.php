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

Route::resources([
    'users' => UserController::class,
    'pharmacies' => PharmacyController::class,
    'check-attributes' => CheckAttributeController::class,
    'checks' => CheckController::class,
    'check-attribute-option' => CheckAttributeOptionController::class,
]);

Route::get('/roles', 'App\Http\Controllers\RoleController@index');

Route::post('user-rating', [UserRatingController::class, 'show']);
Route::get('user-rating', [UserRatingController::class, 'index']);
//Route::get('user/create', [UserController::class, 'create']);
Route::get('create/user', 'App\Http\Controllers\UserController@create');
Route::get('create/pharmacy', 'App\Http\Controllers\PharmacyController@create');
Route::resource('pharmacy-rating',PharmaciesRatingController::class)->only(['index', 'show']);
//Route::post('pharmacy-rating', [PharmacyController::class, 'show']);
//Route::get('/test', function() {
//    return  $pharmacy = App\Models\Pharmacy::all()->last();
//});
