<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;

// Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
Route::get('/plan', [FrontendController::class, 'plan'])->name('plan');
Route::get('/customer-info', [FrontendController::class, 'customerInfo'])->name('customer_info');
Route::get('/agreement', [FrontendController::class, 'agreement'])->name('agreement');
Route::get('/track', [FrontendController::class, 'track'])->name('track');
Route::get('/refund', [FrontendController::class, 'refund'])->name('refund');
Route::post('/refund/agreement', [FrontendController::class, 'refundAgreement'])->name('refund.agreement');
Route::post('/refund/submit', [FrontendController::class, 'submitRefund'])->name('refund.submit');
Route::get('/refund/success', [FrontendController::class, 'refundSuccess'])->name('refund.success');
Route::post('/track/status', [FrontendController::class, 'checkStatus'])->name('track.status');
Route::post('/order/submit', [FrontendController::class, 'submitOrder'])->name('order.submit');

// Calculator Route
Route::get('/calculator', [FrontendController::class, 'calculator'])->name('calculator');
Route::get('/get-models/{brandId}', [FrontendController::class, 'getModels']);

// Admin Login Routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');

// Protected Admin Routes
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // Settings (Logo, Banner)
    Route::post('/admin/settings/update', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

    // Brands Management
    Route::post('/admin/brands/add', [AdminController::class, 'addBrand'])->name('admin.brands.add');
    Route::post('/admin/brands/delete/{id}', [AdminController::class, 'deleteBrand'])->name('admin.brands.delete');

    // Series Management
    Route::post('/admin/series/add', [AdminController::class, 'addSeries'])->name('admin.series.add');
    Route::post('/admin/series/delete/{id}', [AdminController::class, 'deleteSeries'])->name('admin.series.delete');

    // Mobile Management
    Route::post('/admin/mobiles/add', [AdminController::class, 'addMobile'])->name('admin.mobiles.add');
    Route::post('/admin/mobiles/delete/{id}', [AdminController::class, 'deleteMobile'])->name('admin.mobiles.delete');

    // Order Management
    Route::post('/admin/orders/update-status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update_status');
    Route::post('/admin/orders/delete/{id}', [AdminController::class, 'deleteOrder'])->name('admin.orders.delete');

    // Refund Management
    Route::post('/admin/refunds/update-status', [AdminController::class, 'updateRefundStatus'])->name('admin.refunds.update_status');
    Route::post('/admin/refunds/delete/{id}', [AdminController::class, 'deleteRefund'])->name('admin.refunds.delete');

    // Security
    Route::post('/admin/password/update', [AdminController::class, 'updatePassword'])->name('admin.password.update');
});
