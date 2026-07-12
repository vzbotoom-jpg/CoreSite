<?php
// routes/api.php - LENGKAP

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProductApiController;
use App\Http\Controllers\Api\V1\TransactionApiController;
use App\Http\Controllers\Api\V1\ReportApiController;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\Developer\DeveloperController;

/*
|--------------------------------------------------------------------------
| API Routes - LENGKAP
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    
    // ==================== PUBLIC API (No Auth) ====================
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    
    // Public Catalog API
    Route::get('/store/{slug}', [CatalogController::class, 'showStore']);
    Route::get('/store/{slug}/products', [CatalogController::class, 'getProducts']);
    Route::get('/store/{slug}/product/{productSlug}', [CatalogController::class, 'showProduct']);
    Route::get('/store/{slug}/search', [CatalogController::class, 'search']);
    Route::get('/store/{slug}/categories', [CatalogController::class, 'getCategories']);
    
    // ==================== PROTECTED API (Requires Auth) ====================
    Route::middleware('auth:sanctum')->group(function () {
        
        // User Profile
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);
        Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
        Route::post('/resend-verification', [AuthController::class, 'resendVerification']);
        
        // Cart API
        Route::get('/cart', [CartController::class, 'getCart']);
        Route::post('/cart/add', [CartController::class, 'addToCart']);
        Route::put('/cart/update/{id}', [CartController::class, 'updateCartItem']);
        Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart']);
        Route::delete('/cart/clear', [CartController::class, 'clearCart']);
        Route::get('/cart/count', [CartController::class, 'getCartCount']);
        
        // Products API
        Route::apiResource('products', ProductApiController::class);
        Route::post('/products/{product}/adjust-stock', [ProductApiController::class, 'adjustStock']);
        Route::get('/products/{product}/inventory-logs', [ProductApiController::class, 'getInventoryLogs']);
        Route::post('/products/bulk-delete', [ProductApiController::class, 'bulkDelete']);
        Route::get('/products/search', [ProductApiController::class, 'searchProducts']);
        
        // Categories API
        Route::get('/categories', [ProductApiController::class, 'getCategories']);
        Route::post('/categories', [ProductApiController::class, 'createCategory']);
        Route::put('/categories/{category}', [ProductApiController::class, 'updateCategory']);
        Route::delete('/categories/{category}', [ProductApiController::class, 'deleteCategory']);
        
        // Transactions API
        Route::apiResource('transactions', TransactionApiController::class);
        Route::post('/transactions/{transaction}/cancel', [TransactionApiController::class, 'cancel']);
        Route::get('/transactions/{transaction}/invoice', [TransactionApiController::class, 'invoice']);
        Route::get('/transactions/{transaction}/download-invoice', [TransactionApiController::class, 'downloadInvoice']);
        Route::get('/transactions-summary', [TransactionApiController::class, 'summary']);
        
        // Reports API
        Route::get('/reports/monthly', [ReportApiController::class, 'monthlyReport']);
        Route::get('/reports/inventory', [ReportApiController::class, 'inventoryReport']);
        Route::get('/reports/sales', [ReportApiController::class, 'salesReport']);
        Route::get('/reports/daily', [ReportApiController::class, 'dailyReport']);
        Route::get('/reports/profit-loss', [ReportApiController::class, 'profitLoss']);
        Route::get('/dashboard-stats', [ReportApiController::class, 'dashboardStats']);
        Route::get('/dashboard/chart', [ReportApiController::class, 'chartData']);
        
        // Export API
        Route::get('/export/products', [ReportApiController::class, 'exportProducts']);
        Route::get('/export/transactions', [ReportApiController::class, 'exportTransactions']);
        Route::get('/export/report', [ReportApiController::class, 'exportReport']);
        
        // Admin Only (Store Owner)
        Route::middleware('store.owner')->group(function () {
            // Users Management
            Route::get('/admin/users', [\App\Http\Controllers\Admin\SettingController::class, 'getUsers']);
            Route::post('/admin/users', [\App\Http\Controllers\Admin\SettingController::class, 'storeUser']);
            Route::put('/admin/users/{user}', [\App\Http\Controllers\Admin\SettingController::class, 'updateUser']);
            Route::delete('/admin/users/{user}', [\App\Http\Controllers\Admin\SettingController::class, 'deleteUser']);
            Route::post('/admin/users/{user}/toggle-status', [\App\Http\Controllers\Admin\SettingController::class, 'toggleUserStatus']);
            
            // Store Settings
            Route::put('/admin/store', [\App\Http\Controllers\Admin\SettingController::class, 'updateStore']);
            Route::post('/admin/store/logo', [\App\Http\Controllers\Admin\SettingController::class, 'uploadLogo']);
            Route::delete('/admin/store/logo', [\App\Http\Controllers\Admin\SettingController::class, 'deleteLogo']);
            
            // Payment Settings
            Route::get('/admin/settings/payment', [\App\Http\Controllers\Admin\SettingController::class, 'getPaymentSettings']);
            Route::post('/admin/settings/payment', [\App\Http\Controllers\Admin\SettingController::class, 'updatePaymentSettings']);
            Route::post('/admin/settings/qris', [\App\Http\Controllers\Admin\SettingController::class, 'uploadQris']);
            Route::delete('/admin/settings/qris', [\App\Http\Controllers\Admin\SettingController::class, 'deleteQris']);
            
            // Notification Settings
            Route::get('/admin/settings/notification', [\App\Http\Controllers\Admin\SettingController::class, 'getNotificationSettings']);
            Route::post('/admin/settings/notification', [\App\Http\Controllers\Admin\SettingController::class, 'updateNotificationSettings']);
            
            // Preferences
            Route::get('/admin/settings/preferences', [\App\Http\Controllers\Admin\SettingController::class, 'getPreferences']);
            Route::post('/admin/settings/preferences', [\App\Http\Controllers\Admin\SettingController::class, 'updatePreferences']);
        });
    });
});

// ==================== DEVELOPER API ROUTES ====================
Route::prefix('developer')
    ->middleware(['auth', 'developer'])
    ->group(function () {
        // Dashboard Stats
        Route::get('/stats', [DeveloperController::class, 'getDashboardStats']);
        Route::get('/activity/recent', [DeveloperController::class, 'getRecentActivity']);
        
        // Users
        Route::get('/users', [DeveloperController::class, 'getUsersData']);
        Route::post('/users', [DeveloperController::class, 'storeUser']);
        Route::get('/users/{id}', [DeveloperController::class, 'showUser']);
        Route::put('/users/{id}', [DeveloperController::class, 'updateUser']);
        Route::post('/users/{id}/toggle-status', [DeveloperController::class, 'toggleUserStatus']);
        Route::post('/users/{id}/reset-password', [DeveloperController::class, 'resetUserPassword']);
        Route::post('/users/{id}/send-verification', [DeveloperController::class, 'sendUserVerification']);
        Route::delete('/users/{id}', [DeveloperController::class, 'deleteUser']);
        Route::post('/users/{id}/assign-roles', [DeveloperController::class, 'assignUserRoles']);
        
        // Roles
        Route::get('/roles', [DeveloperController::class, 'getRolesData']);
        Route::post('/roles', [DeveloperController::class, 'storeRole']);
        Route::get('/roles/{id}', [DeveloperController::class, 'showRole']);
        Route::put('/roles/{id}', [DeveloperController::class, 'updateRole']);
        Route::post('/roles/{id}/permissions', [DeveloperController::class, 'syncRolePermissions']);
        Route::delete('/roles/{id}', [DeveloperController::class, 'deleteRole']);
        Route::post('/roles/{id}/assign-users', [DeveloperController::class, 'assignRoleUsers']);
        
        // Permissions
        Route::get('/permissions', [DeveloperController::class, 'getPermissionsData']);
        Route::post('/permissions', [DeveloperController::class, 'storePermission']);
        Route::get('/permissions/{id}', [DeveloperController::class, 'showPermission']);
        Route::put('/permissions/{id}', [DeveloperController::class, 'updatePermission']);
        Route::post('/permissions/groups', [DeveloperController::class, 'createPermissionGroup']);
        Route::get('/permissions/groups', [DeveloperController::class, 'getPermissionGroups']);
        Route::delete('/permissions/{id}', [DeveloperController::class, 'deletePermission']);
        
        // Stores
        Route::get('/stores', [DeveloperController::class, 'getStoresData']);
        Route::post('/stores', [DeveloperController::class, 'storeStore']);
        Route::get('/stores/{id}', [DeveloperController::class, 'showStore']);
        Route::put('/stores/{id}', [DeveloperController::class, 'updateStore']);
        Route::post('/stores/{id}/toggle-status', [DeveloperController::class, 'toggleStoreStatus']);
        Route::delete('/stores/{id}', [DeveloperController::class, 'deleteStore']);
        Route::post('/stores/{id}/assign-owner', [DeveloperController::class, 'assignStoreOwner']);
        
        // System
        Route::get('/system/health', [DeveloperController::class, 'systemHealth']);
        Route::get('/system/info', [DeveloperController::class, 'systemInfo']);
        Route::get('/system/cache/stats', [DeveloperController::class, 'cacheStats']);
        Route::post('/system/cache/clear', [DeveloperController::class, 'clearCache']);
        Route::post('/system/cache/clear/{type}', [DeveloperController::class, 'clearCacheType']);
        Route::post('/system/optimize', [DeveloperController::class, 'optimizeApp']);
        
        // Activity Logs
        Route::get('/activity', [DeveloperController::class, 'getActivityData']);
        Route::get('/activity/{id}', [DeveloperController::class, 'showActivity']);
        Route::delete('/activity/clear', [DeveloperController::class, 'clearActivityLogs']);
        Route::delete('/activity/{id}', [DeveloperController::class, 'deleteActivity']);
        
        // Application Logs
        Route::get('/logs', [DeveloperController::class, 'getLogsData']);
        Route::get('/logs/{file}', [DeveloperController::class, 'viewLog']);
        Route::delete('/logs/{file}', [DeveloperController::class, 'deleteLog']);
        Route::delete('/logs', [DeveloperController::class, 'clearLogs']);
        
        // Statistics
        Route::get('/stats/overview', [DeveloperController::class, 'getOverviewStats']);
        Route::get('/stats/users', [DeveloperController::class, 'userStatistics']);
        Route::get('/stats/stores', [DeveloperController::class, 'storeStatistics']);
        Route::get('/stats/transactions', [DeveloperController::class, 'transactionStatistics']);
        Route::get('/stats/system', [DeveloperController::class, 'systemStatistics']);
        
        // Maintenance
        Route::get('/maintenance/status', [DeveloperController::class, 'maintenanceStatus']);
        Route::get('/maintenance/schedules', [DeveloperController::class, 'getMaintenanceSchedules']);
        Route::post('/maintenance/enable', [DeveloperController::class, 'enableMaintenance']);
        Route::post('/maintenance/disable', [DeveloperController::class, 'disableMaintenance']);
        Route::post('/maintenance/settings', [DeveloperController::class, 'updateMaintenanceSettings']);
        Route::post('/maintenance/schedule', [DeveloperController::class, 'scheduleMaintenance']);
        Route::delete('/maintenance/schedule/{id}', [DeveloperController::class, 'cancelMaintenanceSchedule']);
        
        // Backup
        Route::get('/backup/list', [DeveloperController::class, 'getBackupList']);
        Route::get('/backup/settings', [DeveloperController::class, 'getBackupSettings']);
        Route::get('/backup/download/{file}', [DeveloperController::class, 'downloadBackup']);
        Route::post('/backup/create', [DeveloperController::class, 'storeBackup']);
        Route::post('/backup/settings', [DeveloperController::class, 'updateBackupSettings']);
        Route::post('/backup/restore/{file}', [DeveloperController::class, 'restoreBackup']);
        Route::delete('/backup/delete/{file}', [DeveloperController::class, 'deleteBackup']);
        
        // Scheduled Jobs
        Route::get('/jobs', [DeveloperController::class, 'getJobsData']);
        Route::get('/jobs/{job}/logs', [DeveloperController::class, 'getJobLogs']);
        Route::post('/jobs/{job}/run', [DeveloperController::class, 'runScheduledJob']);
        Route::post('/jobs/run-all', [DeveloperController::class, 'runAllJobs']);
        Route::post('/jobs/{job}/enable', [DeveloperController::class, 'enableScheduledJob']);
        Route::post('/jobs/{job}/disable', [DeveloperController::class, 'disableScheduledJob']);
    });

// ==================== WEBHOOK ROUTES (No CSRF, No Auth) ====================
Route::prefix('webhook')->name('api.webhook.')->group(function () {
    Route::post('/payment/{provider}', [WebhookController::class, 'handlePaymentWebhook']);
    Route::post('/midtrans', [WebhookController::class, 'handleMidtransWebhook']);
    Route::post('/xendit', [WebhookController::class, 'handleXenditWebhook']);
    Route::post('/tripay', [WebhookController::class, 'handleTripayWebhook']);
});

// ==================== HEALTH CHECK ====================
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toISOString(),
        'version' => '1.0.0',
        'environment' => app()->environment()
    ]);
});