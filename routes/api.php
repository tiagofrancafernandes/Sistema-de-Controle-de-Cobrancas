<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\CustomerAuthController;
use App\Http\Controllers\Api\TicketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::any('/', fn () => response()->json([
    'name' => config('app.name', 'Laravel'),
    'date' => now(),
]))?->name('index');

Route::middleware('auth:sanctum')->get('/user', fn (Request $request) => $request->user());

Route::prefix('customers')?->name('customers.')->group(function () {
    Route::prefix('auth')?->name('auth.')->group(function () {
        Route::post('login', [CustomerAuthController::class, 'login'])?->name('login');

        Route::middleware('auth:sanctum')->group(function () {
            Route::match(['get', 'post'], '/me', [CustomerAuthController::class, 'me'])?->name('me');
            Route::post('/logout', [CustomerAuthController::class, 'logout'])?->name('logout');
        });
    });
});

Route::prefix('tickets')?->name('tickets.')?->middleware('auth:sanctum')->group(function () {
    Route::match(['get', 'post'], '/', [TicketController::class, 'index'])?->name('index');
});
