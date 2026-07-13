<?php
// routes/web.php - VERSION LENGKAP DAN FIX

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Public\LandingController;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DocsController;

/*
|--------------------------------------------------------------------------
| Web Routes - FIXED VERSION
|--------------------------------------------------------------------------
*/

// ==================== LANDING PAGE ROUTES (Priority: HIGHEST) ====================
Route::get('/', [LandingController::class, 'index'])->name('home'); // DITAMBAHKAN: route home
Route::get('/beranda', [LandingController::class, 'index'])->name('landing'); // Alias untuk landing

Route::get('/about', [LandingController::class, 'about'])->name('about');
Route::get('/pricing', [LandingController::class, 'pricing'])->name('pricing');
Route::get('/contact', [LandingController::class, 'contact'])->name('contact');
Route::get('/features', [LandingController::class, 'features'])->name('features');
Route::post('/contact', [LandingController::class, 'submitContact'])->name('contact.submit');

// ==================== LANDING PAGE ROUTES - ADDITIONAL ====================
Route::get('/demo', [LandingController::class, 'demo'])->name('demo');
Route::get('/changelog', [LandingController::class, 'changelog'])->name('changelog');
Route::get('/roadmap', [LandingController::class, 'roadmap'])->name('roadmap');
Route::get('/careers', [LandingController::class, 'careers'])->name('careers');
Route::get('/team', [LandingController::class, 'team'])->name('team');
Route::get('/guides', [LandingController::class, 'guides'])->name('guides');
Route::get('/documentation', [LandingController::class, 'documentation'])->name('documentation');
Route::get('/status', [LandingController::class, 'status'])->name('status');
Route::get('/cookie-policy', [LandingController::class, 'cookiePolicy'])->name('cookie-policy');
Route::get('/gdpr', [LandingController::class, 'gdpr'])->name('gdpr');
Route::get('/security', [LandingController::class, 'security'])->name('security');
Route::get('/faq', [LandingController::class, 'faq'])->name('faq');

// ==================== STATIC PAGES (Priority: HIGH) ====================
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

// ==================== BLOG ROUTES ====================
Route::prefix('blog')->name('blog.')->group(function () {
    // Blog utama
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/search', [BlogController::class, 'search'])->name('search');
    Route::get('/category/{slug}', [BlogController::class, 'category'])->name('category');
    Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('tag');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('post');
    
    // Subscriber routes
    Route::get('/verify-subscriber/{token}', [BlogController::class, 'verifySubscriber'])->name('verify-subscriber');
    Route::get('/unsubscribe/{token}', [BlogController::class, 'unsubscribe'])->name('unsubscribe');
    Route::get('/unsubscribe/{token}/{email}', [BlogController::class, 'unsubscribe'])->name('unsubscribe.email');
    Route::post('/subscribe', [BlogController::class, 'subscribe'])->name('subscribe');
    
    // Comment routes
    Route::post('/comment/{slug}', [BlogController::class, 'comment'])->name('comment');
    Route::post('/comment/like/{id}', [BlogController::class, 'likeComment'])->name('comment.like');
    
    // API Routes (for AJAX)
    Route::get('/api/posts', [BlogController::class, 'getPosts'])->name('api.posts');
    Route::get('/api/posts/{slug}', [BlogController::class, 'getPost'])->name('api.post');
    Route::get('/api/categories', [BlogController::class, 'getCategories'])->name('api.categories');
    Route::get('/api/tags', [BlogController::class, 'getTags'])->name('api.tags');
});

// ==================== DOCS ROUTES ====================
Route::prefix('docs')->name('docs.')->group(function () {
    Route::get('/', [DocsController::class, 'index'])->name('index');
    Route::get('/search', [DocsController::class, 'search'])->name('search');
    Route::post('/clear-cache', [DocsController::class, 'clearCache'])->name('clear-cache');
    Route::get('/{slug}', [DocsController::class, 'show'])->name('show');
});

// ==================== AUTH ROUTES (Priority: HIGH) ====================
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
    
    // Email Verification
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');
    
    // Two Factor Authentication
    Route::get('/two-factor-challenge', function () {
        return view('auth.two-factor-challenge');
    })->name('two-factor.login');
    
    // Confirm Password
    Route::get('/confirm-password', function () {
        return view('auth.confirm-password');
    })->name('password.confirm');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ==================== PUBLIC CATALOG ROUTES (Priority: MEDIUM) ====================
// Cart Routes (NO SLUG - independent)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/count', [CartController::class, 'getCount'])->name('count');
});

// Checkout Route
Route::get('/checkout', [CartController::class, 'checkout'])->name('catalog.checkout');

// ==================== TENANT/CATALOG ROUTES (Priority: LOWEST - LAST) ====================
// These must be LAST to not interfere with other routes
Route::middleware(['tenant'])->group(function () {
    Route::get('/{slug}', [CatalogController::class, 'showStore'])->name('catalog.store');
    Route::get('/{slug}/product/{productSlug}', [CatalogController::class, 'showProduct'])->name('catalog.product');
    Route::get('/{slug}/category/{categorySlug}', [CatalogController::class, 'showCategory'])->name('catalog.category');
    Route::get('/{slug}/search', [CatalogController::class, 'search'])->name('catalog.search');
});

// ==================== ADMIN ROUTES (Protected) ====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'store.owner'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
    Route::get('/dashboard/chart', [DashboardController::class, 'getChartData'])->name('dashboard.chart');
    Route::get('/dashboard/summary', [DashboardController::class, 'getSummary'])->name('dashboard.summary');
    Route::post('/dashboard/clear-cache', [DashboardController::class, 'clearCache'])->name('dashboard.clear-cache');
    
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

// ==================== DEVELOPER ROUTES (Protected) - HARUS DI PALING AKHIR ====================
require base_path('routes/developer.php');