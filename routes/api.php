<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\PayloadController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/index', [IndexController::class, 'index'])->name('index.index'); // Index endpoints

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    }); // Current user

    Route::group(['prefix' => 'payload', 'as' => 'payload.'], function () {
        Route::get('/', [PayloadController::class, 'index'])->name('index'); // List localizations
        Route::post('/', [PayloadController::class, 'store'])->name('store'); // Store localizations
    });
});
