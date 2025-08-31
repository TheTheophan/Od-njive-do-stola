<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GradController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SlikaController;
use App\Http\Controllers\Api\BiljkaController;
use App\Http\Controllers\Api\FakturaController;
use App\Http\Controllers\Api\GradUsersController;
use App\Http\Controllers\Api\TipPaketaController;
use App\Http\Controllers\Api\PaketBiljakaController;
use App\Http\Controllers\Api\PaketKorisnikaController;
use App\Http\Controllers\Api\PoljoprivrednikController;
use App\Http\Controllers\Api\UserPaketKorisnikasController;
use App\Http\Controllers\Api\GradPoljoprivredniksController;
use App\Http\Controllers\Api\PoljoprivrednikUsersController;
use App\Http\Controllers\Api\PoljoprivrednikSlikasController;
use App\Http\Controllers\Api\BiljkaPoljoprivrednikaController;
use App\Http\Controllers\Api\PaketKorisnikaFakturasController;
use App\Http\Controllers\Api\TipPaketaPaketKorisnikasController;
use App\Http\Controllers\Api\PaketKorisnikaPaketBiljakasController;
use App\Http\Controllers\Api\BiljkaBiljkaPoljoprivrednikasController;
use App\Http\Controllers\Api\BiljkaPoljoprivrednikaPaketBiljakasController;
use App\Http\Controllers\Api\PoljoprivrednikBiljkaPoljoprivrednikasController;

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
        Route::apiResource('grads', GradController::class);

        // Grad Users
        Route::get('/grads/{grad}/users', [
            GradUsersController::class,
            'index',
        ])->name('grads.users.index');
        Route::post('/grads/{grad}/users', [
            GradUsersController::class,
            'store',
        ])->name('grads.users.store');

        // Grad Poljoprivredniks
        Route::get('/grads/{grad}/poljoprivredniks', [
            GradPoljoprivredniksController::class,
            'index',
        ])->name('grads.poljoprivredniks.index');
        Route::post('/grads/{grad}/poljoprivredniks', [
            GradPoljoprivredniksController::class,
            'store',
        ])->name('grads.poljoprivredniks.store');

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

        Route::apiResource(
            'poljoprivredniks',
            PoljoprivrednikController::class
        );

        // Poljoprivrednik Users
        Route::get('/poljoprivredniks/{poljoprivrednik}/users', [
            PoljoprivrednikUsersController::class,
            'index',
        ])->name('poljoprivredniks.users.index');
        Route::post('/poljoprivredniks/{poljoprivrednik}/users', [
            PoljoprivrednikUsersController::class,
            'store',
        ])->name('poljoprivredniks.users.store');

        // Poljoprivrednik Biljka Poljoprivrednikas
        Route::get(
            '/poljoprivredniks/{poljoprivrednik}/biljka-poljoprivrednikas',
            [PoljoprivrednikBiljkaPoljoprivrednikasController::class, 'index']
        )->name('poljoprivredniks.biljka-poljoprivrednikas.index');
        Route::post(
            '/poljoprivredniks/{poljoprivrednik}/biljka-poljoprivrednikas',
            [PoljoprivrednikBiljkaPoljoprivrednikasController::class, 'store']
        )->name('poljoprivredniks.biljka-poljoprivrednikas.store');

        // Poljoprivrednik Slikas
        Route::get('/poljoprivredniks/{poljoprivrednik}/slikas', [
            PoljoprivrednikSlikasController::class,
            'index',
        ])->name('poljoprivredniks.slikas.index');
        Route::post('/poljoprivredniks/{poljoprivrednik}/slikas', [
            PoljoprivrednikSlikasController::class,
            'store',
        ])->name('poljoprivredniks.slikas.store');

        Route::apiResource('biljkas', BiljkaController::class);

        // Biljka Biljka Poljoprivrednikas
        Route::get('/biljkas/{biljka}/biljka-poljoprivrednikas', [
            BiljkaBiljkaPoljoprivrednikasController::class,
            'index',
        ])->name('biljkas.biljka-poljoprivrednikas.index');
        Route::post('/biljkas/{biljka}/biljka-poljoprivrednikas', [
            BiljkaBiljkaPoljoprivrednikasController::class,
            'store',
        ])->name('biljkas.biljka-poljoprivrednikas.store');

        Route::apiResource(
            'biljka-poljoprivrednikas',
            BiljkaPoljoprivrednikaController::class
        );

        // BiljkaPoljoprivrednika Paket Biljakas
        Route::get(
            '/biljka-poljoprivrednikas/{biljkaPoljoprivrednika}/paket-biljakas',
            [BiljkaPoljoprivrednikaPaketBiljakasController::class, 'index']
        )->name('biljka-poljoprivrednikas.paket-biljakas.index');
        Route::post(
            '/biljka-poljoprivrednikas/{biljkaPoljoprivrednika}/paket-biljakas',
            [BiljkaPoljoprivrednikaPaketBiljakasController::class, 'store']
        )->name('biljka-poljoprivrednikas.paket-biljakas.store');

        Route::apiResource('fakturas', FakturaController::class);

        Route::apiResource('paket-biljakas', PaketBiljakaController::class);

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

        // PaketKorisnika Paket Biljakas
        Route::get('/paket-korisnikas/{paketKorisnika}/paket-biljakas', [
            PaketKorisnikaPaketBiljakasController::class,
            'index',
        ])->name('paket-korisnikas.paket-biljakas.index');
        Route::post('/paket-korisnikas/{paketKorisnika}/paket-biljakas', [
            PaketKorisnikaPaketBiljakasController::class,
            'store',
        ])->name('paket-korisnikas.paket-biljakas.store');

        Route::apiResource('slikas', SlikaController::class);

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
    });
