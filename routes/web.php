<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CustomerController;

require __DIR__ . '/auth.php';

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('optimize:clear');

    return "Cleared!";
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/theme', [ProfileController::class, 'toggleTheme'])->name('profile.theme');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('customers', CustomerController::class);

    // Payment Management
    Route::post('/orders/{order}/payments', [OrderController::class, 'collectPayment'])->name('orders.payments.collect');
    Route::resource('deliveries', DeliveryController::class);
    Route::resource('payments', PaymentController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/orders/{order}/invoice/pdf', [ReportController::class, 'orderInvoicePdf'])->name('orders.invoice.pdf');
    Route::get('/reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
    Route::get('/reports/user/{user}', [ReportController::class, 'userReport'])->name('reports.user');
    Route::get('/reports/ledger', [ReportController::class, 'clientLedger'])->name('reports.ledger');

    // Admin / Staff Management
    Route::middleware([RoleMiddleware::class . ':Admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });
});

