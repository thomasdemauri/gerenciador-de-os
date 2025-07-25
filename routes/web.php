<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Reports\ReportsPerClientController;
use App\Http\Controllers\ServiceOrderController;
use App\Models\ServiceOrder;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/service-orders/all', [ServiceOrderController::class, 'index'])->name('service.index');
    Route::get('/service-orders/{order}', [ServiceOrderController::class, 'edit'])->name('service.edit');
    Route::put('/service-orders/{order}', [ServiceOrderController::class, 'update'])->name('service.update');
    Route::delete('/service-orders/{order}', [ServiceOrderController::class, 'delete'])->name('service.delete');
    Route::get('/service-orders', [ServiceOrderController::class, 'create'])->name('service.create');
    Route::post('/service-orders', [ServiceOrderController::class, 'store'])->name('service.store');
    Route::get('/service-orders/download-report/{order}', [ServiceOrderController::class, 'downloadOrderReport'])->name('service.download-order-report');
});

Route::middleware('auth')->group(function () {
    Route::get('/customers/all', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customers/{customer}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'delete'])->name('customer.delete');
    Route::get('/customers', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customer.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/reports/client', [ReportsPerClientController::class, 'index'])->name('reports.client.index');
    Route::get('/reports/download-report-per-client', [ReportsPerClientController::class, 'generateReport'])->name('reports.download-report-per-client');
    Route::get('/reports/month', [ReportsPerClientController::class, 'configureReportPerMonth'])->name('reports.month.index');
    Route::get('/reports/download-report-per-month', [ReportsPerClientController::class, 'downloadReportPerMonth'])->name('reports.download-report-per-month');
});

require __DIR__.'/auth.php';
