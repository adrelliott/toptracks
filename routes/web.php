<?php

use App\Http\Controllers\SpotifyConnectController;
use App\Http\Controllers\SpotifyController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::middleware(['auth', 'verified'])->group(function() {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/connect/spotify/redirect', [SpotifyConnectController::class, 'redirect']);
    Route::get('/connect/spotify/callback', [SpotifyConnectController::class, 'callback']);

    // Temp controller to test
    Route::get('/s/{command}', SpotifyController::class);
    
});

require __DIR__.'/auth.php';
