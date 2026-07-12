<?php
// routes/admin.php - LENGKAP

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| This file is included in web.php under admin prefix
*/

Route::middleware(['auth', 'store.owner'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
    Route::get('/dashboard/chart', [DashboardController::class, 'getChartData'])->name('dashboard.chart');
    
    // Products
    Route::resource('products', ProductController::class);
    Route::post('/products/{product}/adjust-stock', [ProductController::class, 'adjustStock'])->name('products.adjust-stock');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('/products/export/excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
    Route::get('/products/export/pdf', [ProductController::class, 'exportPdf'])->name('products.export.pdf');
    Route::post('/products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');
    Route::post('/products/bulk-status', [ProductController::class, 'bulkStatus'])->name('products.bulk-status');
    
    // Transactions
    Route::resource('transactions', TransactionController::class);
    Route::get('/transactions/{transaction}/invoice', [TransactionController::class, 'invoice'])->name('transactions.invoice');
    Route::get('/transactions/{transaction}/invoice-preview', [TransactionController::class, 'invoicePreview'])->name('transactions.invoice-preview');
    Route::post('/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('transactions.cancel');
    Route::get('/transactions/summary', [TransactionController::class, 'summary'])->name('transactions.summary');
    Route::get('/transactions/export/excel', [TransactionController::class, 'exportExcel'])->name('transactions.export.excel');
    Route::get('/transactions/export/pdf', [TransactionController::class, 'exportPdf'])->name('transactions.export.pdf');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/financial', [ReportController::class, 'monthlyReport'])->name('reports.financial');
    Route::get('/reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
    Route::get('/reports/inventory', [ReportController::class, 'inventoryReport'])->name('reports.inventory');
    Route::get('/reports/profit-loss', [ReportController::class, 'profitLoss'])->name('reports.profit-loss');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    
    // Settings - Profile
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/profile', [SettingController::class, 'profile'])->name('settings.profile');
    Route::put('/settings/store', [SettingController::class, 'updateStore'])->name('settings.store');
    Route::post('/settings/logo', [SettingController::class, 'uploadLogo'])->name('settings.logo');
    Route::delete('/settings/logo', [SettingController::class, 'deleteLogo'])->name('settings.logo.delete');
    
    // Settings - Users
    Route::get('/settings/users', [SettingController::class, 'users'])->name('settings.users');
    Route::get('/settings/users-data', [SettingController::class, 'getUsers'])->name('settings.users.data');
    Route::post('/settings/users', [SettingController::class, 'storeUser'])->name('settings.users.store');
    Route::put('/settings/users/{user}', [SettingController::class, 'updateUser'])->name('settings.users.update');
    Route::delete('/settings/users/{user}', [SettingController::class, 'deleteUser'])->name('settings.users.delete');
    Route::post('/settings/users/{user}/toggle-status', [SettingController::class, 'toggleUserStatus'])->name('settings.users.toggle');
    
    // Settings - Payment
    Route::get('/settings/payment', [SettingController::class, 'payment'])->name('settings.payment');
    Route::get('/settings/payment-data', [SettingController::class, 'getPaymentSettings'])->name('settings.payment.data');
    Route::post('/settings/payment', [SettingController::class, 'updatePaymentSettings'])->name('settings.payment.update');
    Route::post('/settings/qris', [SettingController::class, 'uploadQris'])->name('settings.qris.upload');
    Route::delete('/settings/qris', [SettingController::class, 'deleteQris'])->name('settings.qris.delete');
    
    // Settings - Notification
    Route::get('/settings/notification', [SettingController::class, 'notification'])->name('settings.notification');
    Route::get('/settings/notification-data', [SettingController::class, 'getNotificationSettings'])->name('settings.notification.data');
    Route::post('/settings/notification', [SettingController::class, 'updateNotificationSettings'])->name('settings.notification.update');
    
    // Settings - Preferences
    Route::get('/settings/preferences', [SettingController::class, 'preferences'])->name('settings.preferences');
    Route::get('/settings/preferences-data', [SettingController::class, 'getPreferences'])->name('settings.preferences.data');
    Route::post('/settings/preferences', [SettingController::class, 'updatePreferences'])->name('settings.preferences.update');
});