{{-- resources/views/layouts/partials/blog-sidebar.blade.php --}}
<div class="sticky top-24 max-h-[calc(100vh-6rem)] overflow-y-auto space-y-10 pr-2">
    <!-- Journal Title -->
    <div class="pb-6 border-b border-light-border/40 dark:border-dark-border/40">
        <h2 class="text-xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
            Edukasi UMKM
        </h2>
        <p class="text-xs text-text-secondary/70 mt-2 leading-relaxed">
            Strategi pemasaran, pembukuan keuangan, dan update fitur CoreSite untuk memajukan bisnis Anda.
        </p>
    </div>

    <!-- Search -->
    <div>
        <h4 class="text-xs font-bold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-4">
            Cari Artikel
        </h4>
        <form action="{{ route('blog.search') }}" method="GET" class="relative">
            <input 
                type="text" 
                name="q" 
                placeholder="Cari artikel..."
                class="w-full px-4 py-2.5 bg-light-surface dark:bg-dark-surface border border-light-border dark:border-dark-border rounded-lg text-text-primary dark:text-text-dark-primary placeholder:text-text-secondary/60 focus:ring-1 focus:ring-accent/50 transition outline-none text-sm"
            >
            <button 
                type="submit" 
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-text-secondary/60 hover:text-accent transition"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </form>
    </div>

    <!-- Subscribe -->
    <div class="bg-accent/5 border border-accent/10 rounded-xl p-5">
        <h4 class="text-xs font-bold text-accent uppercase tracking-wider mb-2">
            Langganan Buletin
        </h4>
        <p class="text-xs text-text-secondary dark:text-text-dark-secondary mb-4 leading-relaxed">
            Dapatkan tips bisnis mingguan yang telah dibaca oleh 1,000+ pemilik UMKM.
        </p>
        <form action="{{ route('blog.subscribe') }}" method="POST" class="space-y-3">
            @csrf
            <input 
                type="email" 
                name="email" 
                placeholder="Alamat email Anda"
                class="w-full px-4 py-2 bg-light-bg dark:bg-dark-bg border border-light-border dark:border-dark-border rounded-lg text-text-primary dark:text-text-dark-primary placeholder:text-text-secondary/60 focus:ring-1 focus:ring-accent/50 transition outline-none text-xs"
                required
            >
            <button 
                type="submit" 
                class="w-full px-4 py-2 bg-accent hover:bg-accent-hover text-white font-bold rounded-lg transition text-xs"
            >
                Langganan
            </button>
        </form>
    </div>

    <!-- Top Guides / Artikel Pilihan -->
    <div>
        <h4 class="text-xs font-bold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-4">
            Artikel Pilihan
        </h4>
        <div class="space-y-3">
            <a href="{{ route('guides') }}" class="block group">
                <span class="text-[10px] text-accent font-bold uppercase tracking-wider">Panduan</span>
                <p class="text-xs font-semibold text-text-primary dark:text-text-dark-primary group-hover:text-accent transition mt-0.5">
                    Langkah Awal Membangun E-Catalog Toko Online
                </p>
            </a>
            <a href="{{ route('guides') }}" class="block group">
                <span class="text-[10px] text-accent font-bold uppercase tracking-wider">Kasir POS</span>
                <p class="text-xs font-semibold text-text-primary dark:text-text-dark-primary group-hover:text-accent transition mt-0.5">
                    Cara Cetak Struk Kasir Lewat Bluetooth Thermal Printer
                </p>
            </a>
        </div>
    </div>

    <!-- Categories -->
    <div>
        <h4 class="text-xs font-bold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-4">
            Kategori
        </h4>
        <div class="space-y-1.5">
            @foreach($categories ?? [] as $category)
            <a 
                href="{{ route('blog.category', $category->slug) }}" 
                class="flex justify-between items-center py-1.5 text-xs text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition group"
            >
                <span class="group-hover:underline">{{ $category->name }}</span>
                <span class="text-[10px] font-bold text-text-secondary/60 bg-light-surface dark:bg-dark-surface px-1.5 py-0.5 rounded-full border border-light-border dark:border-dark-border/40">{{ $category->posts_count ?? 0 }}</span>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Recent Posts -->
    <div>
        <h4 class="text-xs font-bold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-4">
            Artikel Terbaru
        </h4>
        <div class="space-y-4">
            @foreach($recentPosts ?? [] as $recent)
            <a href="{{ route('blog.post', $recent->slug) }}" class="block group">
                <p class="text-xs font-bold text-text-primary dark:text-text-dark-primary group-hover:text-accent transition leading-snug">
                    {{ $recent->title }}
                </p>
                <p class="text-[10px] text-text-secondary/60 mt-1">{{ $recent->created_at->format('d/m/Y') }}</p>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Tags -->
    @if(isset($tags) && count($tags) > 0)
    <div>
        <h4 class="text-xs font-bold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-4">
            Label / Tag
        </h4>
        <div class="flex flex-wrap gap-1.5">
            @foreach($tags as $tag)
            <a 
                href="{{ route('blog.tag', $tag->slug) }}" 
                class="text-[10px] font-semibold px-2.5 py-1 rounded-full bg-light-surface dark:bg-dark-surface text-text-secondary hover:text-accent hover:bg-accent/5 transition border border-light-border dark:border-dark-border/40"
            >
                {{ $tag->name }}
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>