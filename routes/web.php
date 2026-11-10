<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return app(SiteController::class)->home();
});
Route::post('/contact', [ContactController::class, 'store'])->name('site.contact.store');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');

Route::redirect('/administrador', '/admin/login');
Route::redirect('/administrador/inicio', '/admin/dashboard');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [AdminController::class, 'dashboard'])
        ->middleware(['auth', 'admin'])
        ->name('home');

    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function (): void {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
        Route::post('/services/{service}/move', [AdminServiceController::class, 'move'])->name('services.move');
        Route::resource('services', AdminServiceController::class)->except(['show', 'destroy']);
        Route::post('/content/{content}/move', [ContentController::class, 'move'])->name('content.move');
        Route::post('/content/images', [ContentController::class, 'uploadImage'])->name('content.images.store');
        Route::resource('content', ContentController::class)->except(['show', 'destroy']);
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});
