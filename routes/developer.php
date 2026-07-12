<?php
// routes/developer.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Developer\DeveloperController;

/*
|--------------------------------------------------------------------------
| Developer Routes
|--------------------------------------------------------------------------
| Routes for developer dashboard and system management
| All routes are protected by 'auth' and 'developer' middleware
*/

Route::prefix('developer')->name('developer.')->middleware(['auth', 'developer'])->group(function () 
{
    
    // ==================== DASHBOARD ====================
    Route::get('/', function() {
        return redirect()->route('developer.dashboard');
    });
    Route::get('/dashboard', [DeveloperController::class, 'index'])->name('dashboard');
    
    // API Routes for Dashboard
    Route::get('/api/stats', [DeveloperController::class, 'getDashboardStats'])->name('api.stats');
    Route::get('/api/activity/recent', [DeveloperController::class, 'getRecentActivities'])->name('api.activity.recent');
    
    // ==================== USER MANAGEMENT ====================
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [DeveloperController::class, 'users'])->name('index');
        Route::get('/data', [DeveloperController::class, 'getUsersData'])->name('data');
        Route::get('/create', [DeveloperController::class, 'createUser'])->name('create');
        Route::post('/', [DeveloperController::class, 'storeUser'])->name('store');
        Route::get('/{id}', [DeveloperController::class, 'showUser'])->name('show');
        Route::get('/{id}/edit', [DeveloperController::class, 'editUser'])->name('edit');
        Route::put('/{id}', [DeveloperController::class, 'updateUser'])->name('update');
        Route::post('/{id}/toggle-status', [DeveloperController::class, 'toggleUserStatus'])->name('toggle');
        Route::post('/{id}/reset-password', [DeveloperController::class, 'resetUserPassword'])->name('reset-password');
        Route::post('/{id}/send-verification', [DeveloperController::class, 'sendUserVerification'])->name('send-verification');
        Route::delete('/{id}', [DeveloperController::class, 'deleteUser'])->name('delete');
        Route::post('/{id}/assign-roles', [DeveloperController::class, 'assignUserRoles'])->name('assign-roles');
    });
    
    // ==================== ROLE MANAGEMENT ====================
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [DeveloperController::class, 'roles'])->name('index');
        Route::get('/data', [DeveloperController::class, 'getRolesData'])->name('data');
        Route::get('/create', [DeveloperController::class, 'createRole'])->name('create');
        Route::post('/', [DeveloperController::class, 'storeRole'])->name('store');
        Route::get('/{id}', [DeveloperController::class, 'showRole'])->name('show');
        Route::get('/{id}/edit', [DeveloperController::class, 'editRole'])->name('edit');
        Route::put('/{id}', [DeveloperController::class, 'updateRole'])->name('update');
        Route::post('/{id}/permissions', [DeveloperController::class, 'syncRolePermissions'])->name('permissions');
        Route::delete('/{id}', [DeveloperController::class, 'deleteRole'])->name('delete');
        Route::post('/{id}/assign-users', [DeveloperController::class, 'assignRoleUsers'])->name('assign-users');
    });
    
    // ==================== PERMISSION MANAGEMENT ====================
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [DeveloperController::class, 'permissions'])->name('index');
        Route::get('/data', [DeveloperController::class, 'getPermissionsData'])->name('data');
        Route::get('/create', [DeveloperController::class, 'createPermission'])->name('create');
        Route::post('/', [DeveloperController::class, 'storePermission'])->name('store');
        Route::post('/groups', [DeveloperController::class, 'createPermissionGroup'])->name('group');
        Route::get('/groups', [DeveloperController::class, 'getPermissionGroups'])->name('groups');
        Route::get('/{id}', [DeveloperController::class, 'showPermission'])->name('show');
        Route::get('/{id}/edit', [DeveloperController::class, 'editPermission'])->name('edit');
        Route::put('/{id}', [DeveloperController::class, 'updatePermission'])->name('update');
        Route::delete('/{id}', [DeveloperController::class, 'deletePermission'])->name('delete');
    });
    
    // ==================== STORE MANAGEMENT ====================
    Route::prefix('stores')->name('stores.')->group(function () {
        Route::get('/', [DeveloperController::class, 'stores'])->name('index');
        Route::get('/data', [DeveloperController::class, 'getStoresData'])->name('data');
        Route::get('/create', [DeveloperController::class, 'createStore'])->name('create');
        Route::post('/', [DeveloperController::class, 'storeStore'])->name('store');
        Route::get('/{id}', [DeveloperController::class, 'showStore'])->name('show');
        Route::get('/{id}/edit', [DeveloperController::class, 'editStore'])->name('edit');
        Route::put('/{id}', [DeveloperController::class, 'updateStore'])->name('update');
        Route::post('/{id}/toggle-status', [DeveloperController::class, 'toggleStoreStatus'])->name('toggle');
        Route::delete('/{id}', [DeveloperController::class, 'deleteStore'])->name('delete');
        Route::post('/{id}/assign-owner', [DeveloperController::class, 'assignStoreOwner'])->name('assign-owner');
    });
    
    // ==================== SYSTEM MANAGEMENT ====================
    Route::prefix('system')->name('system.')->group(function () {
        Route::get('/', [DeveloperController::class, 'system'])->name('index');
        Route::get('/info', [DeveloperController::class, 'systemInfo'])->name('info');
        Route::get('/cache', [DeveloperController::class, 'cacheManagement'])->name('cache');
        Route::get('/database', [DeveloperController::class, 'databaseManagement'])->name('database');
        Route::get('/phpinfo', [DeveloperController::class, 'phpInfo'])->name('phpinfo');
        Route::get('/health', [DeveloperController::class, 'systemHealth'])->name('health');
        
        // Cache Management
        Route::prefix('cache')->name('cache.')->group(function () {
            Route::get('/stats', [DeveloperController::class, 'cacheStats'])->name('stats');
            Route::post('/clear', [DeveloperController::class, 'clearCache'])->name('clear');
            Route::post('/clear/{type}', [DeveloperController::class, 'clearCacheType'])->name('clear-type');
            Route::post('/warmup', [DeveloperController::class, 'warmupCache'])->name('warmup');
        });
        
        // Database Management
        Route::prefix('database')->name('db.')->group(function () {
            Route::get('/stats', [DeveloperController::class, 'databaseStats'])->name('stats');
            Route::get('/tables', [DeveloperController::class, 'databaseTables'])->name('tables');
            Route::post('/migrate', [DeveloperController::class, 'runMigration'])->name('migrate');
            Route::post('/rollback', [DeveloperController::class, 'rollbackMigration'])->name('rollback');
            Route::post('/seed', [DeveloperController::class, 'runSeeder'])->name('seed');
            Route::post('/reset', [DeveloperController::class, 'resetDatabase'])->name('reset');
            Route::post('/refresh', [DeveloperController::class, 'refreshDatabase'])->name('refresh');
            Route::post('/query', [DeveloperController::class, 'runDatabaseQuery'])->name('query');
        });
        
        // Optimization
        Route::post('/optimize', [DeveloperController::class, 'optimizeApp'])->name('optimize');
        Route::post('/optimize/clear', [DeveloperController::class, 'clearOptimized'])->name('optimize-clear');
        Route::post('/clear', [DeveloperController::class, 'clearApplication'])->name('clear');
    });
    
    // ==================== LOGS ====================
    Route::prefix('logs')->name('logs.')->group(function () {
        Route::get('/', [DeveloperController::class, 'logs'])->name('index');
        Route::get('/data', [DeveloperController::class, 'getLogsData'])->name('data');
        Route::get('/{file}', [DeveloperController::class, 'viewLog'])->name('view');
        Route::get('/download/{file}', [DeveloperController::class, 'downloadLog'])->name('download');
        Route::delete('/', [DeveloperController::class, 'clearLogs'])->name('clear');
        Route::delete('/{file}', [DeveloperController::class, 'deleteLog'])->name('delete');
    });
    
    // ==================== ACTIVITY LOGS ====================
    Route::prefix('activity')->name('activity.')->group(function () {
        Route::get('/', [DeveloperController::class, 'activityLogs'])->name('index');
        Route::get('/data', [DeveloperController::class, 'getActivityData'])->name('data');
        Route::get('/recent', [DeveloperController::class, 'getRecentActivity'])->name('recent');
        Route::get('/{id}', [DeveloperController::class, 'showActivity'])->name('show');
        Route::delete('/clear', [DeveloperController::class, 'clearActivityLogs'])->name('clear');
        Route::delete('/{id}', [DeveloperController::class, 'deleteActivity'])->name('delete');
    });
    
    // ==================== STATISTICS ====================
    Route::prefix('stats')->name('stats.')->group(function () {
        Route::get('/', [DeveloperController::class, 'statistics'])->name('index');
        Route::get('/overview', [DeveloperController::class, 'getOverviewStats'])->name('overview');
        Route::get('/users', [DeveloperController::class, 'userStatistics'])->name('users');
        Route::get('/stores', [DeveloperController::class, 'storeStatistics'])->name('stores');
        Route::get('/transactions', [DeveloperController::class, 'transactionStatistics'])->name('transactions');
        Route::get('/system', [DeveloperController::class, 'systemStatistics'])->name('system');
    });
    
    // ==================== MAINTENANCE MODE ====================
    Route::prefix('maintenance')->name('maintenance.')->group(function () {
        Route::get('/', [DeveloperController::class, 'maintenanceIndex'])->name('index');
        Route::get('/status', [DeveloperController::class, 'maintenanceStatus'])->name('status');
        Route::get('/schedules', [DeveloperController::class, 'getMaintenanceSchedules'])->name('schedules');
        Route::post('/enable', [DeveloperController::class, 'enableMaintenance'])->name('enable');
        Route::post('/disable', [DeveloperController::class, 'disableMaintenance'])->name('disable');
        Route::post('/settings', [DeveloperController::class, 'updateMaintenanceSettings'])->name('settings');
        Route::post('/schedule', [DeveloperController::class, 'scheduleMaintenance'])->name('schedule');
        Route::delete('/schedule/{id}', [DeveloperController::class, 'cancelMaintenanceSchedule'])->name('cancel');
    });
    
    // ==================== BACKUP ====================
    Route::prefix('backup')->name('backup.')->group(function () {
        Route::get('/', [DeveloperController::class, 'backups'])->name('index');
        Route::get('/create', [DeveloperController::class, 'createBackupView'])->name('create');
        Route::get('/list', [DeveloperController::class, 'getBackupList'])->name('list');
        Route::get('/settings', [DeveloperController::class, 'getBackupSettings'])->name('settings');
        Route::get('/download/{file}', [DeveloperController::class, 'downloadBackup'])->name('download');
        Route::post('/create', [DeveloperController::class, 'storeBackup'])->name('store');
        Route::post('/settings', [DeveloperController::class, 'updateBackupSettings'])->name('settings.update');
        Route::post('/restore/{file}', [DeveloperController::class, 'restoreBackup'])->name('restore');
        Route::delete('/delete/{file}', [DeveloperController::class, 'deleteBackup'])->name('delete');
    });
    
    // ==================== SCHEDULED JOBS ====================
    Route::prefix('jobs')->name('jobs.')->group(function () {
        Route::get('/', [DeveloperController::class, 'scheduledJobs'])->name('index');
        Route::get('/data', [DeveloperController::class, 'getJobsData'])->name('data');
        Route::get('/logs/{job}', [DeveloperController::class, 'getJobLogs'])->name('logs');
        Route::post('/run/{job}', [DeveloperController::class, 'runScheduledJob'])->name('run');
        Route::post('/run-all', [DeveloperController::class, 'runAllJobs'])->name('run-all');
        Route::post('/enable/{job}', [DeveloperController::class, 'enableScheduledJob'])->name('enable');
        Route::post('/disable/{job}', [DeveloperController::class, 'disableScheduledJob'])->name('disable');
        Route::post('/schedule', [DeveloperController::class, 'scheduleNewJob'])->name('schedule');
        Route::delete('/{job}', [DeveloperController::class, 'deleteScheduledJob'])->name('delete');
    });
});