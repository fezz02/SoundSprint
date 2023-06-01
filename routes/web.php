<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LobbyController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::group(['prefix' => 'matchmaking', 'as' => 'mmk.'], function () {
        Route::get('/', [LobbyController::class, 'index'])->name('index');
        Route::get('create', [LobbyController::class, 'create'])->name('create');
    });

    Route::group(['prefix' => 'play', 'as' => 'play.'], function () {
        Route::get('/', [GameController::class, 'index'])->name('index');
        Route::get('/{lobby_code}', [GameController::class, 'join'])->name('join');
        Route::post('/{lobby_code}', [GameController::class, 'guessTrack'])->name('guessTrack');
    });
    


    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });



});



require __DIR__.'/auth.php';
