<?php
// app/Http/Controllers/Public/LandingController.php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Show landing page
     */
    public function index()
    {
        // Get featured stores (recently active)
        $featuredStores = Store::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        
        // Stats for landing page
        $stats = [
            'total_stores' => Store::where('is_active', true)->count(),
            'total_transactions' => Transaction::count(),
            'active_users' => User::where('is_active', true)->count(),
        ];
        
        return view('landing.index', compact('featuredStores', 'stats'));
    }
    
    /**
     * Show about page
     */
    public function about()
    {
        // Team members data
        $team = [
            [
                'name' => 'John Doe',
                'role' => 'Founder & CEO',
                'description' => 'Visioner di balik CoreSite dengan passion memberdayakan UMKM',
                'avatar' => 'https://ui-avatars.com/api/?background=00D27A&color=fff&name=John+Doe&size=100'
            ],
            [
                'name' => 'Jane Smith',
                'role' => 'CTO',
                'description' => 'Ahli teknologi dengan pengalaman 10+ tahun di industri software',
                'avatar' => 'https://ui-avatars.com/api/?background=6366F1&color=fff&name=Jane+Smith&size=100'
            ],
            [
                'name' => 'Mike Johnson',
                'role' => 'COO',
                'description' => 'Memastikan operasional berjalan lancar dan pelanggan puas',
                'avatar' => 'https://ui-avatars.com/api/?background=F59E0B&color=fff&name=Mike+Johnson&size=100'
            ],
            [
                'name' => 'Sarah Lee',
                'role' => 'Lead Designer',
                'description' => 'Menciptakan pengalaman visual yang modern dan intuitif',
                'avatar' => 'https://ui-avatars.com/api/?background=EF4444&color=fff&name=Sarah+Lee&size=100'
            ],
            [
                'name' => 'Alex Chen',
                'role' => 'Lead Developer',
                'description' => 'Membangun arsitektur yang scalable dan aman',
                'avatar' => 'https://ui-avatars.com/api/?background=8B5CF6&color=fff&name=Alex+Chen&size=100'
            ],
            [
                'name' => 'Maria Garcia',
                'role' => 'Customer Success',
                'description' => 'Memastikan setiap pelanggan mendapatkan pengalaman terbaik',
                'avatar' => 'https://ui-avatars.com/api/?background=EC4899&color=fff&name=Maria+Garcia&size=100'
            ]
        ];
        
        // Company stats
        $stats = [
            'users' => User::count(),
            'stores' => Store::count(),
            'transactions' => Transaction::count(),
            'satisfaction' => 95,
        ];
        
        return view('landing.about', compact('team', 'stats'));
    }
    
    /**
     * Show pricing page
     */
    public function pricing()
    {
        $plans = [
            'starter' => [
                'name' => 'Starter',
                'price' => 0,
                'period' => 'Selamanya',
                'features' => [
                    '1 Toko',
                    'Maksimal 100 produk',
                    'Laporan dasar',
                    'Support email',
                    'E-catalog publik'
                ],
                'recommended' => false
            ],
            'business' => [
                'name' => 'Business',
                'price' => 149000,
                'period' => '/bulan',
                'features' => [
                    '1 Toko',
                    'Unlimited produk',
                    'Laporan lengkap',
                    'Priority support',
                    'E-catalog publik',
                    'Export data',
                    'Multi user (3 user)'
                ],
                'recommended' => true
            ],
            'enterprise' => [
                'name' => 'Enterprise',
                'price' => 499000,
                'period' => '/bulan',
                'features' => [
                    '5 Toko',
                    'Unlimited produk',
                    'Laporan advanced',
                    'Dedicated support',
                    'E-catalog premium',
                    'API access',
                    'Multi user (unlimited)',
                    'Custom domain'
                ],
                'recommended' => false
            ]
        ];
        
        // FAQ data
        $faqs = [
            [
                'question' => 'Apakah ada biaya pendaftaran?',
                'answer' => 'Tidak ada biaya pendaftaran. Anda bisa memulai dengan paket gratis (Starter) dan upgrade kapan saja.'
            ],
            [
                'question' => 'Bagaimana cara membuat toko online?',
                'answer' => 'Setelah mendaftar, Anda akan dipandu melalui proses setup toko. Tambahkan produk, atur tampilan, dan mulai berjualan.'
            ],
            [
                'question' => 'Apakah bisa digunakan untuk beberapa toko?',
                'answer' => 'Ya! Dengan paket Enterprise, Anda bisa mengelola hingga 5 toko sekaligus dalam satu akun.'
            ],
            [
                'question' => 'Apa saja metode pembayaran yang tersedia?',
                'answer' => 'CoreSite mendukung QRIS, transfer bank, dan pembayaran tunai. Kami terus menambahkan integrasi baru.'
            ]
        ];
        
        return view('landing.pricing', compact('plans', 'faqs'));
    }
    
    /**
     * Show contact page
     */
    public function contact()
    {
        return view('landing.contact');
    }
    
    /**
     * Handle contact form submission
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // TODO: Send email notification
        // Mail::to(config('mail.admin_email'))->send(new ContactMail($validated));
        
        // TODO: Save to database
        // Contact::create($validated);
        
        return back()->with('success', 'Pesan Anda telah terkirim. Kami akan menghubungi Anda segera.');
    }
    
    /**
     * Show demo page
     */
    public function demo()
    {
        return view('landing.demo');
    }
    
    /**
     * Show changelog page
     */
    public function changelog()
    {
        $changelogs = [
            [
                'version' => 'v1.2.0',
                'date' => '17 Juni 2026',
                'is_latest' => true,
                'badge' => 'Terbaru',
                'badge_type' => 'success',
                'changes' => [
                    'Menambahkan fitur export laporan keuangan ke Excel',
                    'Meningkatkan performa dashboard admin',
                    'Memperbaiki bug pada sistem kasir'
                ]
            ],
            [
                'version' => 'v1.1.0',
                'date' => '10 Juni 2026',
                'is_latest' => false,
                'badge' => null,
                'badge_type' => null,
                'changes' => [
                    'Menambahkan fitur multi-user untuk toko',
                    'Integrasi QRIS untuk pembayaran'
                ]
            ],
            [
                'version' => 'v1.0.0',
                'date' => '1 Juni 2026',
                'is_latest' => false,
                'badge' => 'Rilis Pertama',
                'badge_type' => 'primary',
                'changes' => [
                    'Launching platform CoreSite',
                    'Fitur toko online dan kasir otomatis',
                    'Laporan keuangan dan inventori'
                ]
            ]
        ];
        
        return view('landing.changelog', compact('changelogs'));
    }
    
    /**
     * Show roadmap page
     */
    public function roadmap()
    {
        $roadmaps = [
            [
                'quarter' => 'Q3 2026',
                'period' => 'Juli - September',
                'badge_type' => 'primary',
                'items' => [
                    'Fitur multi-toko untuk satu akun',
                    'Integrasi dengan marketplace (Shopee, Tokopedia)',
                    'Mobile app untuk kasir'
                ]
            ],
            [
                'quarter' => 'Q4 2026',
                'period' => 'Oktober - Desember',
                'badge_type' => 'accent',
                'items' => [
                    'AI-powered inventory management',
                    'Customer loyalty program',
                    'Advanced reporting & analytics'
                ]
            ],
            [
                'quarter' => 'Q1 2027',
                'period' => 'Januari - Maret',
                'badge_type' => 'secondary',
                'items' => [
                    'Integrasi dengan POS hardware',
                    'Multi-language support',
                    'API public untuk developer'
                ]
            ],
            [
                'quarter' => 'Coming Soon',
                'period' => 'Fitur yang sedang dikembangkan',
                'badge_type' => 'warning',
                'is_coming_soon' => true,
                'items' => [
                    'Chatbot support untuk pelanggan',
                    'Automatic inventory restock alerts',
                    'WhatsApp Business integration'
                ]
            ]
        ];
        
        return view('landing.roadmap', compact('roadmaps'));
    }
    
    /**
     * Show careers page
     */
    public function careers()
    {
        $positions = [
            [
                'title' => 'Full Stack Developer',
                'department' => 'Engineering',
                'location' => 'Remote',
                'type' => 'Full-time',
                'description' => 'Bangun dan maintain platform CoreSite dengan teknologi terbaru.'
            ],
            [
                'title' => 'UI/UX Designer',
                'department' => 'Design',
                'location' => 'Remote',
                'type' => 'Full-time',
                'description' => 'Desain pengalaman pengguna yang modern dan intuitif untuk platform CoreSite.'
            ],
            [
                'title' => 'Customer Success Manager',
                'department' => 'Support',
                'location' => 'Remote',
                'type' => 'Full-time',
                'description' => 'Pastikan setiap pelanggan mendapatkan pengalaman terbaik dengan CoreSite.'
            ]
        ];
        
        $benefits = [
            [
                'icon' => '💻',
                'title' => 'Remote Work',
                'description' => 'Bekerja dari mana saja dengan tim yang tersebar'
            ],
            [
                'icon' => '🚀',
                'title' => 'Growth',
                'description' => 'Peluang berkembang dan belajar teknologi terbaru'
            ],
            [
                'icon' => '🌍',
                'title' => 'Impact',
                'description' => 'Memberdayakan ribuan UMKM di Indonesia'
            ]
        ];
        
        return view('landing.careers', compact('positions', 'benefits'));
    }
    
    /**
     * Show team page
     */
    public function team()
    {
        $teamMembers = [
            [
                'name' => 'John Doe',
                'role' => 'Founder & CEO',
                'description' => 'Visioner di balik CoreSite dengan passion memberdayakan UMKM',
                'avatar' => 'https://ui-avatars.com/api/?background=00D27A&color=fff&name=John+Doe&size=100'
            ],
            [
                'name' => 'Jane Smith',
                'role' => 'CTO',
                'description' => 'Ahli teknologi dengan pengalaman 10+ tahun di industri software',
                'avatar' => 'https://ui-avatars.com/api/?background=6366F1&color=fff&name=Jane+Smith&size=100'
            ],
            [
                'name' => 'Mike Johnson',
                'role' => 'COO',
                'description' => 'Memastikan operasional berjalan lancar dan pelanggan puas',
                'avatar' => 'https://ui-avatars.com/api/?background=F59E0B&color=fff&name=Mike+Johnson&size=100'
            ],
            [
                'name' => 'Sarah Lee',
                'role' => 'Lead Designer',
                'description' => 'Menciptakan pengalaman visual yang modern dan intuitif',
                'avatar' => 'https://ui-avatars.com/api/?background=EF4444&color=fff&name=Sarah+Lee&size=100'
            ],
            [
                'name' => 'Alex Chen',
                'role' => 'Lead Developer',
                'description' => 'Membangun arsitektur yang scalable dan aman',
                'avatar' => 'https://ui-avatars.com/api/?background=8B5CF6&color=fff&name=Alex+Chen&size=100'
            ],
            [
                'name' => 'Maria Garcia',
                'role' => 'Customer Success',
                'description' => 'Memastikan setiap pelanggan mendapatkan pengalaman terbaik',
                'avatar' => 'https://ui-avatars.com/api/?background=EC4899&color=fff&name=Maria+Garcia&size=100'
            ]
        ];
        
        return view('landing.team', compact('teamMembers'));
    }
    
    /**
     * Show guides page
     */
    public function guides()
    {
        $guides = [
            [
                'icon' => '📖',
                'title' => 'Panduan Memulai CoreSite',
                'description' => 'Pelajari dasar-dasar penggunaan CoreSite dalam 10 menit',
                'slug' => 'getting-started'
            ],
            [
                'icon' => '🛒',
                'title' => 'Cara Menambahkan Produk',
                'description' => 'Panduan menambahkan dan mengelola produk di toko Anda',
                'slug' => 'add-products'
            ],
            [
                'icon' => '💰',
                'title' => 'Mengelola Transaksi',
                'description' => 'Cara mencatat dan mengelola transaksi penjualan',
                'slug' => 'manage-transactions'
            ],
            [
                'icon' => '📊',
                'title' => 'Membaca Laporan Keuangan',
                'description' => 'Memahami laporan keuangan dan analisis bisnis Anda',
                'slug' => 'financial-reports'
            ],
            [
                'icon' => '📱',
                'title' => 'Mengatur E-Catalog Publik',
                'description' => 'Tips membuat halaman toko online yang menarik',
                'slug' => 'e-catalog'
            ]
        ];
        
        return view('landing.guides', compact('guides'));
    }
    
    /**
     * Show documentation page
     */
    public function documentation()
    {
        $docs = [
            [
                'icon' => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4',
                'title' => 'API Reference',
                'description' => 'Dokumentasi lengkap API CoreSite untuk integrasi',
                'link' => '#'
            ],
            [
                'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
                'title' => 'SDK & Libraries',
                'description' => 'SDK dan library untuk berbagai bahasa pemrograman',
                'link' => '#'
            ],
            [
                'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                'title' => 'Webhooks',
                'description' => 'Dokumentasi webhooks untuk event real-time',
                'link' => '#'
            ],
            [
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'title' => 'Best Practices',
                'description' => 'Panduan praktik terbaik menggunakan CoreSite',
                'link' => '#'
            ]
        ];
        
        return view('landing.documentation', compact('docs'));
    }
    
    /**
     * Show status page
     */
    public function status()
    {
        $services = [
            [
                'name' => 'Website & Dashboard',
                'description' => 'Akses platform dan dashboard admin',
                'status' => 'operational',
                'status_text' => 'Operational'
            ],
            [
                'name' => 'API Services',
                'description' => 'API dan integrasi pihak ketiga',
                'status' => 'operational',
                'status_text' => 'Operational'
            ],
            [
                'name' => 'Database & Storage',
                'description' => 'Database dan penyimpanan file',
                'status' => 'operational',
                'status_text' => 'Operational'
            ],
            [
                'name' => 'E-Catalog Public',
                'description' => 'Halaman toko publik pelanggan',
                'status' => 'operational',
                'status_text' => 'Operational'
            ]
        ];
        
        $overall_status = 'operational';
        $last_checked = now();
        
        return view('landing.status', compact('services', 'overall_status', 'last_checked'));
    }
    
    /**
     * Show cookie policy page
     */
    public function cookiePolicy()
    {
        return view('landing.cookie-policy');
    }
    
    /**
     * Show GDPR page
     */
    public function gdpr()
    {
        return view('landing.gdpr');
    }
    
    /**
     * Show security page
     */
    public function security()
    {
        $features = [
            [
                'icon' => '🔒',
                'title' => 'Enkripsi Data',
                'description' => 'Semua data dienkripsi dengan AES-256 baik saat transit maupun istirahat'
            ],
            [
                'icon' => '🛡️',
                'title' => 'SSL/TLS',
                'description' => 'Koneksi aman dengan sertifikat SSL/TLS untuk semua komunikasi'
            ],
            [
                'icon' => '🔑',
                'title' => 'Akses Terbatas',
                'description' => 'Hanya tim terbatas yang memiliki akses ke data Anda dengan otorisasi ketat'
            ],
            [
                'icon' => '📋',
                'title' => 'Audit & Monitoring',
                'description' => 'Audit dan monitoring keamanan dilakukan secara berkala'
            ]
        ];
        
        $certifications = [
            'ISO 27001 Certified (dalam proses)',
            'GDPR Compliant',
            'PCI DSS Level 1 (untuk pembayaran)'
        ];
        
        return view('landing.security', compact('features', 'certifications'));
    }
    
    /**
     * Show FAQ page
     */
    public function faq()
    {
        $faqs = [
            [
                'question' => 'Apa itu CoreSite?',
                'answer' => 'CoreSite adalah platform toko online dan kasir otomatis yang dirancang khusus untuk UMKM Indonesia.'
            ],
            [
                'question' => 'Apakah ada biaya pendaftaran?',
                'answer' => 'Tidak ada biaya pendaftaran. Anda bisa memulai dengan paket gratis (Starter) dan upgrade kapan saja.'
            ],
            [
                'question' => 'Bagaimana cara membuat toko online?',
                'answer' => 'Setelah mendaftar, Anda akan dipandu melalui proses setup toko. Tidak perlu keahlian teknis!'
            ],
            [
                'question' => 'Apakah bisa digunakan untuk beberapa toko?',
                'answer' => 'Ya! Dengan paket Enterprise, Anda bisa mengelola hingga 5 toko sekaligus.'
            ],
            [
                'question' => 'Apa saja metode pembayaran yang tersedia?',
                'answer' => 'CoreSite mendukung QRIS, transfer bank, dan pembayaran tunai.'
            ],
            [
                'question' => 'Apakah ada dukungan jika saya mengalami masalah?',
                'answer' => 'Tentu saja! Kami menyediakan dukungan melalui email, chat, dan dokumentasi lengkap.'
            ],
            [
                'question' => 'Bagaimana cara upgrade paket?',
                'answer' => 'Anda bisa upgrade paket kapan saja melalui dashboard. Proses upgrade instan.'
            ]
        ];
        
        return view('landing.faq', compact('faqs'));
    }
    
    /**
     * Show blog page
     */
    public function blog()
    {
        $posts = [
            [
                'title' => 'Cara Memulai Toko Online untuk Pemula',
                'excerpt' => 'Panduan lengkap untuk memulai toko online dari nol. Cocok untuk UMKM yang baru memulai digitalisasi.',
                'category' => 'Tips',
                'date' => '17 Juni 2026',
                'slug' => 'cara-memulai-toko-online'
            ],
            [
                'title' => '5 Strategi Pemasaran Digital untuk UMKM',
                'excerpt' => 'Tingkatkan penjualan dengan strategi pemasaran digital yang terbukti efektif untuk UMKM.',
                'category' => 'Strategi',
                'date' => '15 Juni 2026',
                'slug' => 'strategi-pemasaran-digital'
            ],
            [
                'title' => 'Mengelola Keuangan Bisnis dengan Mudah',
                'excerpt' => 'Tips mengelola keuangan bisnis menggunakan sistem kasir otomatis dan laporan terintegrasi.',
                'category' => 'Keuangan',
                'date' => '12 Juni 2026',
                'slug' => 'mengelola-keuangan-bisnis'
            ]
        ];
        
        return view('landing.blog', compact('posts'));
    }
    
    /**
     * Show blog post detail
     */
    public function blogPost($slug)
    {
        // In real application, fetch post from database
        $post = [
            'title' => 'Cara Memulai Toko Online untuk Pemula',
            'content' => 'Membuka toko online mungkin terasa menakutkan, tetapi dengan langkah yang tepat, Anda bisa memulai dengan mudah.',
            'category' => 'Tips',
            'date' => '17 Juni 2026',
            'author' => 'Admin',
            'slug' => $slug
        ];
        
        return view('landing.blog-post', compact('post'));
    }
    
    /**
     * Show terms page
     */
    public function terms()
    {
        return view('landing.terms');
    }
    
    /**
     * Show privacy page
     */
    public function privacy()
    {
        return view('landing.privacy');
    }

    /**
     * Show features page
     */
    public function features()
    {
        $features = [
            [
                'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10',
                'title' => 'Manajemen Produk',
                'description' => 'Kelola produk dengan mudah, termasuk stok, harga, dan kategori.',
                'benefits' => [
                    'Tambah, edit, dan hapus produk',
                    'Kelola stok dan harga',
                    'Peringatan stok menipis'
                ]
            ],
            [
                'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                'title' => 'E-Katalog Profesional',
                'description' => 'Buat dan kelola katalog digital profesional dengan URL unik.',
                'benefits' => [
                    'URL toko unik',
                    'Tampilan responsif',
                    'Kustomisasi tema warna'
                ]
            ],
            [
                'icon' => 'M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
                'title' => 'Transaksi Kasir (POS)',
                'description' => 'Sistem Point of Sale yang cepat dan akurat untuk transaksi harian.',
                'benefits' => [
                    'Proses transaksi cepat',
                    'Metode pembayaran lengkap',
                    'Cetak invoice otomatis'
                ]
            ],
            [
                'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                'title' => 'Laporan & Analitik',
                'description' => 'Pantau performa bisnis dengan laporan dan analitik real-time.',
                'benefits' => [
                    'Laporan penjualan',
                    'Analitik produk terlaris',
                    'Ekspor data ke Excel/PDF'
                ]
            ],
            [
                'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                'title' => 'Multi-User Support',
                'description' => 'Kelola tim dengan hak akses yang berbeda sesuai peran masing-masing.',
                'benefits' => [
                    'Kelola anggota tim',
                    'Hak akses berbasis peran',
                    'Pantau aktivitas tim'
                ]
            ],
            [
                'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
                'title' => 'Keamanan Terjamin',
                'description' => 'Data bisnis Anda dilindungi dengan enkripsi dan standar keamanan terbaik.',
                'benefits' => [
                    'Enkripsi AES-256',
                    'SSL/TLS secure connection',
                    'Backup data otomatis'
                ]
            ]
        ];

        $additionalFeatures = [
            [
                'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'title' => 'Harga Terjangkau',
                'description' => 'Mulai dari Rp49.000/bulan'
            ],
            [
                'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
                'title' => 'Aplikasi Mobile',
                'description' => 'Tersedia di PlayStore'
            ],
            [
                'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                'title' => 'Desktop App',
                'description' => 'Windows, Mac, Linux'
            ],
            [
                'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'title' => 'Support 24/7',
                'description' => 'Tim siap membantu Anda'
            ]
        ];

        $stats = [
            'products_managed' => number_format(50000),
            'transactions_processed' => number_format(100000),
            'active_stores' => number_format(1500),
            'satisfaction_rate' => '95%'
        ];

        return view('landing.features', compact('features', 'additionalFeatures', 'stats'));
    }
}