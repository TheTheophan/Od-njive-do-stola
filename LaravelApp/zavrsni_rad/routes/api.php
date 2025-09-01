<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FakturaController;
use App\Http\Controllers\Api\TipPaketaController;
use App\Http\Controllers\Api\PaketKorisnikaController;
use App\Http\Controllers\Api\UserPaketKorisnikasController;
use App\Http\Controllers\Api\PaketKorisnikaFakturasController;
use App\Http\Controllers\Api\TipPaketaPaketKorisnikasController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('fakturas', FakturaController::class);

        Route::apiResource('paket-korisnikas', PaketKorisnikaController::class);

        // PaketKorisnika Fakturas
        Route::get('/paket-korisnikas/{paketKorisnika}/fakturas', [
            PaketKorisnikaFakturasController::class,
            'index',
        ])->name('paket-korisnikas.fakturas.index');
        Route::post('/paket-korisnikas/{paketKorisnika}/fakturas', [
            PaketKorisnikaFakturasController::class,
            'store',
        ])->name('paket-korisnikas.fakturas.store');

        Route::apiResource('tip-paketas', TipPaketaController::class);

        // TipPaketa Paket Korisnikas
        Route::get('/tip-paketas/{tipPaketa}/paket-korisnikas', [
            TipPaketaPaketKorisnikasController::class,
            'index',
        ])->name('tip-paketas.paket-korisnikas.index');
        Route::post('/tip-paketas/{tipPaketa}/paket-korisnikas', [
            TipPaketaPaketKorisnikasController::class,
            'store',
        ])->name('tip-paketas.paket-korisnikas.store');

        Route::apiResource('users', UserController::class);

        // User Paket Korisnikas
        Route::get('/users/{user}/paket-korisnikas', [
            UserPaketKorisnikasController::class,
            'index',
        ])->name('users.paket-korisnikas.index');
        Route::post('/users/{user}/paket-korisnikas', [
            UserPaketKorisnikasController::class,
            'store',
        ])->name('users.paket-korisnikas.store');
    });
