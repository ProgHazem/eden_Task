<?php

use App\Http\Controllers\Api\Manager\LoginController as ManagerLogin;
use App\Http\Controllers\Api\Manager\JobController as ManagerJob;
use App\Http\Controllers\Api\Regular\LoginController as RegularLogin;
use App\Http\Controllers\Api\Regular\JobController as RegularJob;
use Illuminate\Support\Facades\Route;
use App\Http\Enums\UserRoles;


/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Api!
|
*/


Route::group([
    'prefix' => 'v1',
], function () {

    Route::group([
        'prefix' => 'manager',
    ], function () {
        Route::post('login', [ManagerLogin::class, 'login']);
        Route::group(['middleware' => ['auth:api', 'role:' . UserRoles::ROLE_MANGER]], function () {
            Route::delete('logout', [ManagerLogin::class, 'logout']);
            Route::get('jobs', [ManagerJob::class, 'index']);
        });
    });

    Route::group([
        'namespace' => 'Regular',
        'prefix' => 'regular',
    ], function () {
        Route::post('login', [RegularLogin::class, 'login']);
        Route::group(['middleware' => ['auth:api', 'role:' . UserRoles::ROLE_REGULAR]], function () {
            Route::delete('logout', [RegularLogin::class, 'logout']);
            Route::post('jobs', [RegularJob::class, 'create']);
            Route::put('jobs/{id}', [RegularJob::class, 'update']);
        });
    });

});
