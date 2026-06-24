<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('store');
})->name('store');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');

    Route::middleware('admin')->group(function (): void {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('categories', AdminCategoryController::class)->except('show');
        Route::resource('products', AdminProductController::class)->except('show');
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::get('users', AdminUserController::class)->name('users.index');
    });
});
