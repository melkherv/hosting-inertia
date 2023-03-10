<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\SshKeyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\DigitalOceanController;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/providers', [ProviderController::class, 'index'])->name('providers');
    Route::post('/tokens', [ProviderController::class, 'store'])->name('provider.token.store');
    Route::delete('/token', [ProviderController::class, 'deleteToken'])->name('provider.token.delete');
    Route::put('/token-update', [ProviderController::class, 'updateToken'])->name('provider.token.update');

    Route::get('/ssh-keys', [SshKeyController::class, 'index'])->name('ssh-keys');
    Route::post('/ssh-key-store', [SshKeyController::class, 'store'])->name('ssh.key.store');
    Route::put('/ssh-key-update', [SshKeyController::class, 'update'])->name('ssh.key.update');
    Route::delete('/ssh-key-delete', [SshKeyController::class, 'deleteKey'])->name('ssh.key.delete');

    Route::get('/servers', [DigitalOceanController::class, 'index'])->name('servers');
});

require __DIR__ . '/auth.php';
