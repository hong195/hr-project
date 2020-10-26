<?php

use App\Http\Controllers\CheckAttributeController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\UserController;
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

//Route::get('/test', function() {
//    return  $pharmacy = App\Models\Pharmacy::all()->last();
//});
