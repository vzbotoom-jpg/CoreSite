<?php
// app/Http/Controllers/DocsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DocsController extends Controller
{
    /**
     * Cache duration in minutes
     */
    protected const CACHE_DURATION = 60;

    /**
     * Documentation pages configuration
     */
    protected const PAGES = [
        // Getting Started
        'introduction' => [
            'title' => 'Pengenalan',
            'view' => 'docs.introduction',
            'category' => 'getting-started',
            'order' => 1,
        ],
        'quick-start' => [
            'title' => 'Mulai Cepat',
            'view' => 'docs.quick-start',
            'category' => 'getting-started',
            'order' => 2,
        ],
        'installation' => [
            'title' => 'Instalasi',
            'view' => 'docs.installation',
            'category' => 'getting-started',
            'order' => 3,
        ],
        
        // Core Features
        'product-management' => [
            'title' => 'Manajemen Produk',
            'view' => 'docs.product-management',
            'category' => 'core-features',
            'order' => 4,
        ],
        'e-catalog-setup' => [
            'title' => 'Pengaturan E-Katalog',
            'view' => 'docs.e-catalog-setup',
            'category' => 'core-features',
            'order' => 5,
        ],
        'pos-transactions' => [
            'title' => 'Transaksi Kasir',
            'view' => 'docs.pos-transactions',
            'category' => 'core-features',
            'order' => 6,
        ],
        
        // Company Information
        'changelog' => [
            'title' => 'Riwayat Pembaruan',
            'view' => 'docs.changelog',
            'category' => 'company-info',
            'order' => 7,
        ],
        'roadmap' => [
            'title' => 'Peta Jalan',
            'view' => 'docs.roadmap',
            'category' => 'company-info',
            'order' => 8,
        ],
        'security' => [
            'title' => 'Keamanan',
            'view' => 'docs.security',
            'category' => 'company-info',
            'order' => 9,
        ],
        
        // Advanced
        'exporting-data' => [
            'title' => 'Ekspor Data',
            'view' => 'docs.exporting-data',
            'category' => 'advanced',
            'order' => 10,
        ],
        'faq' => [
            'title' => 'FAQ',
            'view' => 'docs.faq',
            'category' => 'advanced',
            'order' => 11,
        ],
        
        // API Reference
        'api-overview' => [
            'title' => 'Gambaran API',
            'view' => 'docs.api-overview',
            'category' => 'api-reference',
            'order' => 12,
        ],
        'authentication' => [
            'title' => 'Autentikasi',
            'view' => 'docs.authentication',
            'category' => 'api-reference',
            'order' => 13,
        ],
        'endpoints' => [
            'title' => 'Endpoint',
            'view' => 'docs.endpoints',
            'category' => 'api-reference',
            'order' => 14,
        ],

        // Account & Billing
        'registration' => [
            'title' => 'Registrasi & Mulai Cepat',
            'view' => 'docs.registration',
            'category' => 'account-billing',
            'order' => 15,
        ],
        'dashboard-guide' => [
            'title' => 'Panduan Dashboard',
            'view' => 'docs.dashboard-guide',
            'category' => 'account-billing',
            'order' => 16,
        ],
        'profile-settings' => [
            'title' => 'Pengaturan Akun',
            'view' => 'docs.profile-settings',
            'category' => 'account-billing',
            'order' => 17,
        ],
        'reports-analytics' => [
            'title' => 'Laporan & Analitik',
            'view' => 'docs.reports-analytics',
            'category' => 'account-billing',
            'order' => 18,
        ],
        'subscription' => [
            'title' => 'Paket & Harga',
            'view' => 'docs.subscription',
            'category' => 'account-billing',
            'order' => 19,
        ],
        'billing' => [
            'title' => 'Penagihan & Invoice',
            'view' => 'docs.billing',
            'category' => 'account-billing',
            'order' => 20,
        ],
        'support' => [
            'title' => 'Hubungi Dukungan',
            'view' => 'docs.support',
            'category' => 'account-billing',
            'order' => 21,
        ],
    ];

    /**
     * Categories configuration
     */
    protected const CATEGORIES = [
        'getting-started' => 'Mulai',
        'core-features' => 'Fitur Utama',
        'company-info' => 'Informasi Perusahaan',
        'advanced' => 'Lanjutan',
        'api-reference' => 'Referensi API',
        'account-billing' => 'Akun & Langganan',
    ];

    /**
     * Show documentation index.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->route('docs.show', 'introduction');
    }

    /**
     * Show a documentation page.
     * 
     * @param string $slug
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, $slug)
    {
        $pages = $this->getPagesWithCache();

        if (!isset($pages[$slug])) {
            // Handle 404 with friendly message
            abort(404, "Halaman dokumentasi '{$slug}' tidak ditemukan.");
        }

        // Get current page data
        $currentPage = $pages[$slug];
        $currentPage['slug'] = $slug;

        // Get navigation data
        $navigation = $this->buildNavigation($pages, $slug);
        $previous = $navigation['previous'] ?? null;
        $next = $navigation['next'] ?? null;

        // Get category pages
        $categoryPages = $this->getCategoryPages($pages, $currentPage['category']);

        return view($currentPage['view'], [
            'title' => $currentPage['title'],
            'slug' => $slug,
            'previous' => $previous,
            'next' => $next,
            'category' => $this->getCategoryName($currentPage['category']),
            'categoryPages' => $categoryPages,
            'navigation' => $navigation,
            'tableOfContents' => $this->generateTableOfContents($slug),
            'lastUpdated' => $this->getLastUpdated($slug),
        ]);
    }

    /**
     * Get documentation pages with caching.
     * 
     * @return array
     */
    protected function getPagesWithCache()
    {
        return Cache::remember('docs_pages', self::CACHE_DURATION, function () {
            return self::PAGES;
        });
    }

    /**
     * Build navigation (previous/next pages).
     * 
     * @param array $pages
     * @param string $currentSlug
     * @return array
     */
    protected function buildNavigation(array $pages, string $currentSlug): array
    {
        // Sort pages by order
        usort($pages, function ($a, $b) {
            return ($a['order'] ?? 999) <=> ($b['order'] ?? 999);
        });

        $slugs = array_keys($pages);
        $currentIndex = array_search($currentSlug, $slugs);

        return [
            'previous' => $currentIndex > 0 ? [
                'slug' => $slugs[$currentIndex - 1],
                'title' => $pages[$slugs[$currentIndex - 1]]['title'],
            ] : null,
            'next' => $currentIndex < count($slugs) - 1 ? [
                'slug' => $slugs[$currentIndex + 1],
                'title' => $pages[$slugs[$currentIndex + 1]]['title'],
            ] : null,
        ];
    }

    /**
     * Get pages by category.
     * 
     * @param array $pages
     * @param string $category
     * @return array
     */
    protected function getCategoryPages(array $pages, string $category): array
    {
        $categoryPages = array_filter($pages, function ($page) use ($category) {
            return ($page['category'] ?? '') === $category;
        });

        // Sort by order
        usort($categoryPages, function ($a, $b) {
            return ($a['order'] ?? 999) <=> ($b['order'] ?? 999);
        });

        return $categoryPages;
    }

    /**
     * Get category name.
     * 
     * @param string $category
     * @return string|null
     */
    protected function getCategoryName(string $category): ?string
    {
        return self::CATEGORIES[$category] ?? null;
    }

    /**
     * Get all categories.
     * 
     * @return array
     */
    public function getCategories(): array
    {
        return self::CATEGORIES;
    }

    /**
     * Generate table of contents for a page.
     * 
     * @param string $slug
     * @return array
     */
    protected function generateTableOfContents(string $slug): array
    {
        // You can implement this to parse markdown/HTML content
        // and extract headings for TOC
        return [];
    }

    /**
     * Get last updated date for a page.
     * 
     * @param string $slug
     * @return string|null
     */
    protected function getLastUpdated(string $slug): ?string
    {
        // Check if view file exists and get its last modified time
        try {
            $viewPath = resource_path('views/docs/' . $slug . '.blade.php');
            if (File::exists($viewPath)) {
                return date('d M Y', File::lastModified($viewPath));
            }
        } catch (\Exception $e) {
            return null;
        }
        return null;
    }

    /**
     * Search documentation.
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $results = [];

        if (!empty($query)) {
            $pages = $this->getPagesWithCache();
            
            foreach ($pages as $slug => $page) {
                // Search in title and content
                if (stripos($page['title'], $query) !== false) {
                    $results[] = [
                        'slug' => $slug,
                        'title' => $page['title'],
                        'category' => $this->getCategoryName($page['category'] ?? ''),
                    ];
                }
            }
        }

        return view('docs.search', [
            'query' => $query,
            'results' => $results,
        ]);
    }

    /**
     * Clear documentation cache.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearCache()
    {
        Cache::forget('docs_pages');
        
        return response()->json([
            'message' => 'Documentation cache cleared successfully.',
        ]);
    }
}