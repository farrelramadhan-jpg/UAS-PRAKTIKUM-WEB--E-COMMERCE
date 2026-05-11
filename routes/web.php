<?php

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('products.index');
});

// Public routes for products (outside auth middleware)
Route::middleware('guest')->group(function () {
    Route::get('/products', function () {
        return view('products.index');
    })->name('products.public.index');

    Route::get('/products/{product}', function ($product) {
        return view('products.show');
    })->name('products.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('products.index');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.products.index');
        })->name('admin.dashboard');

        Route::resource('products', AdminProductController::class);
    });

    // Categories routes - Admin only
    Route::resource('categories', CategoryController::class)->middleware('role:admin');
});

// Admin routes (separate from auth middleware)
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.products.index');
    })->name('admin.dashboard');

    Route::resource('products', AdminProductController::class);
});

require __DIR__.'/auth.php';
