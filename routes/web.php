<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\LogisticsController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Analytics (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('/analytics/export', [AnalyticsController::class, 'exportCsv'])->name('analytics.export');
    });

    // Map (all authenticated roles)
    Route::get('/map', [MapController::class, 'index'])->name('map.index');

    // Notifications (all roles)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Transport Management
    Route::middleware('role:admin,transport_manager')->group(function () {
        Route::get('/transport', [TransportController::class, 'index'])->name('transport.index');
        Route::get('/transport/create', [TransportController::class, 'create'])->name('transport.create');
        Route::post('/transport', [TransportController::class, 'store'])->name('transport.store');
        Route::get('/transport/{transport}/edit', [TransportController::class, 'edit'])->name('transport.edit');
        Route::patch('/transport/{transport}', [TransportController::class, 'update'])->name('transport.update');
        Route::delete('/transport/{transport}', [TransportController::class, 'destroy'])->name('transport.destroy');
    });

    // Logistics Management
    Route::middleware('role:admin,logistics_manager')->group(function () {
        Route::get('/logistics', [LogisticsController::class, 'index'])->name('logistics.index');
        Route::get('/logistics/create', [LogisticsController::class, 'create'])->name('logistics.create');
        Route::post('/logistics', [LogisticsController::class, 'store'])->name('logistics.store');
        // Warehouse sub-routes — must come BEFORE {delivery} wildcard
        Route::get('/logistics/warehouses', [LogisticsController::class, 'warehouses'])->name('logistics.warehouses');
        Route::get('/logistics/warehouses/create', [LogisticsController::class, 'createWarehouse'])->name('logistics.warehouses.create');
        Route::post('/logistics/warehouses', [LogisticsController::class, 'storeWarehouse'])->name('logistics.warehouses.store');
        // Delivery CRUD — wildcard routes last
        Route::get('/logistics/{delivery}/edit', [LogisticsController::class, 'edit'])->name('logistics.edit');
        Route::patch('/logistics/{delivery}', [LogisticsController::class, 'update'])->name('logistics.update');
        Route::delete('/logistics/{delivery}', [LogisticsController::class, 'destroy'])->name('logistics.destroy');
    });

    // Resource Management
    Route::middleware('role:admin,citizen')->group(function () {
        Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
        Route::get('/resources/create', [ResourceController::class, 'create'])->name('resources.create');
        Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
        Route::get('/resources/{resource}/edit', [ResourceController::class, 'edit'])->name('resources.edit');
        Route::patch('/resources/{resource}', [ResourceController::class, 'update'])->name('resources.update');
        Route::delete('/resources/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/auth.php';
