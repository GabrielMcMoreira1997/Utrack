<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.index');
})->name('home');

Route::get('/register', function () {
    return view('public.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('links')->group(function () {
        Route::put('/{id}', [App\Http\Controllers\LinkController::class, 'edit'])->name('links.edit');
        Route::delete('/{id}', [App\Http\Controllers\LinkController::class, 'destroy'])->name('links.destroy');

        Route::get('/report', [App\Http\Controllers\LinkController::class, 'report'])->name('links.report');
        Route::post('/qr-code', [App\Http\Controllers\QrCodeController::class, 'generate'])->name('generate.qr');
        Route::post('/generate-short-code', [App\Http\Controllers\LinkController::class, 'generateShortCode'])->name('generate.short_code');

    });

    Route::prefix('users')->group(function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/create', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::get('/show/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
        Route::post('/edit/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::prefix('tags')->group(function () {
        Route::get('/', [App\Http\Controllers\TagController::class, 'index'])->name('tags.index');
        Route::get('/create', [App\Http\Controllers\TagController::class, 'create'])->name('tags.create');
        Route::post('/create', [App\Http\Controllers\TagController::class, 'store'])->name('tags.store');
        Route::get('/edit/{id}', [App\Http\Controllers\TagController::class, 'edit'])->name('tags.edit');
        Route::get('/show/{id}', [App\Http\Controllers\TagController::class, 'show'])->name('tags.show');
        Route::put('/edit/{id}', [App\Http\Controllers\TagController::class, 'update'])->name('tags.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\TagController::class, 'destroy'])->name('tags.destroy');
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [App\Http\Controllers\RoleController::class, 'create'])->name('roles.create');
        Route::post('/create', [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
        Route::get('/edit/{id}', [App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
        Route::get('/show/{id}', [App\Http\Controllers\RoleController::class, 'show'])->name('roles.show');
        Route::post('/edit/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');
    });
});

Route::post('/shorten', [App\Http\Controllers\LinkController::class, 'shorten'])->name('shorten');
Route::get('/{code}',   [App\Http\Controllers\LinkController::class, 'redirect'])->name('redirect');

require __DIR__.'/auth.php';
