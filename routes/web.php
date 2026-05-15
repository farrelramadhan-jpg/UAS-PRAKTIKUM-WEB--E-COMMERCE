<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PublicProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\ModeratorCommentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

// Public routes for products
Route::get('/', [PublicProductController::class, 'index'])->name('home');
Route::get('/products', [PublicProductController::class, 'index'])->name('products.public.index');
Route::get('/products/{product}', [PublicProductController::class, 'show'])->name('products.public.show');
 
// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (auth()->user()->role === 'seller') {
            return redirect()->route('seller.dashboard');
        }

        if (auth()->user()->role === 'moderator') {
            return redirect()->route('moderator.dashboard');
        }

        return redirect()->route('products.public.index');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Comment routes
    Route::resource('comments', CommentController::class)->only(['store', 'destroy']);
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Checkout & customer orders
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders/{order}', [CheckoutController::class, 'show'])->name('orders.user.show');

    // Seller routes
    Route::prefix('seller')->middleware(['role:seller'])->name('seller.')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
        Route::resource('products', ProductController::class);
        Route::resource('orders', OrderController::class)->only(['index', 'show']);
        Route::resource('customers', CustomerController::class)->only(['index', 'show']);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // Moderator routes
    Route::prefix('moderator')->middleware(['role:moderator'])->name('moderator.')->group(function () {
        Route::get('/dashboard', [ModeratorController::class, 'index'])->name('dashboard');

        // Comment management routes
        Route::get('/comments', [ModeratorCommentController::class, 'index'])->name('comments.index');
        Route::get('/comments/{comment}', [ModeratorCommentController::class, 'show'])->name('comments.show');
        Route::post('/comments/{comment}/approve', [ModeratorCommentController::class, 'approve'])->name('comments.approve');
        Route::post('/comments/{comment}/reject', [ModeratorCommentController::class, 'reject'])->name('comments.reject');
        Route::delete('/comments/{comment}', [ModeratorCommentController::class, 'destroy'])->name('comments.destroy');
        Route::post('/comments/bulk-action', [ModeratorCommentController::class, 'bulkAction'])->name('comments.bulk-action');
    });

    // Admin routes
    Route::prefix('admin')->middleware(['role:admin'])->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return redirect()->route('admin.dashboard.main');
        })->name('dashboard');
        
        Route::get('/dashboard-main', function () {
            return view('admin.dashboard');
        })->name('dashboard.main');

        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('users', UserManagementController::class)->only(['index', 'destroy']);
        Route::patch('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.updateRole');
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});

require __DIR__.'/auth.php';
