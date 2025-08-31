<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GradController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SlikaController;
use App\Http\Controllers\BiljkaController;
use App\Http\Controllers\FakturaController;
use App\Http\Controllers\TipPaketaController;
use App\Http\Controllers\PaketBiljakaController;
use App\Http\Controllers\PaketKorisnikaController;
use App\Http\Controllers\PoljoprivrednikController;
use App\Http\Controllers\BiljkaPoljoprivrednikaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('grads', GradController::class);
        Route::resource('users', UserController::class);
        Route::resource('poljoprivredniks', PoljoprivrednikController::class);
        Route::resource('biljkas', BiljkaController::class);
        Route::resource(
            'biljka-poljoprivrednikas',
            BiljkaPoljoprivrednikaController::class
        );
        Route::resource('fakturas', FakturaController::class);
        Route::resource('paket-biljakas', PaketBiljakaController::class);
        Route::resource('paket-korisnikas', PaketKorisnikaController::class);
        Route::resource('slikas', SlikaController::class);
        Route::resource('tip-paketas', TipPaketaController::class);
    });
