<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\BranchController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

Route::redirect('/', '/login');

Route::resource('products', ProductController::class);
Route::get('stock-out-products', [ProductController::class, 'stockOutList'])->name('products.stock_out_list');
Route::post('products/{product}/stock-out', [ProductController::class, 'stockOut'])->name('products.stock-out');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');

    Route::resource('categories', CategoryController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('users', \App\Http\Controllers\Backend\UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password.edit');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

require __DIR__ . '/auth.php';
