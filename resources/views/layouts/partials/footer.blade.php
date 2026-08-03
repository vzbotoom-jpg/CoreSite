{{-- resources/views/layouts/partials/footer.blade.php --}}
<footer class="bg-black text-[#A0A5B0] border-t border-slate-900 mt-20 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Footer Content in 5 columns on desktop -->
        <div class="py-16 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
            <!-- Kolom 1 (Kiri Utama): Brand Column (takes 2 columns span on small screen if preferred, or standard 1 column) -->
            <div class="col-span-2 md:col-span-3 lg:col-span-1 max-w-xs space-y-4">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-accent rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-xl">C</span>
                    </div>
                    <span class="font-bold text-xl text-white">CoreSite</span>
                </div>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                    SaaS E-Commerce &amp; automatic POS platform for MSMEs. Establish your dynamic store website and professional e-catalog in minutes.
                </p>
                <div class="flex items-center gap-3">
                    <a href="#" class="text-slate-500 hover:text-[#00D27A] transition-colors duration-200" aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-slate-500 hover:text-[#00D27A] transition-colors duration-200" aria-label="Twitter">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-slate-500 hover:text-[#00D27A] transition-colors duration-200" aria-label="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-slate-500 hover:text-[#00D27A] transition-colors duration-200" aria-label="YouTube">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Kolom 2: Products & Platform (Bertumpuk) -->
            <div class="space-y-10">
                <!-- Blok Atas: Products -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Products</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a @if(Route::has('features')) href="{{ route('features') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">Store Builder</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">E-Catalog Portal</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Automatic POS</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Inventory Control</a></li>
                        <li><a @if(Route::has('pricing')) href="{{ route('pricing') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">SaaS Pricing</a></li>
                        <li><a @if(Route::has('demo')) href="{{ route('demo') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">Interactive Demo</a></li>
                    </ul>
                </div>
                <!-- Blok Bawah: Platform / Models -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">CoreSite Platform</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a @if(Route::has('developer.dashboard')) href="{{ route('developer.dashboard') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">Overview</a></li>
                        <li><a @if(Route::has('developer.system.health')) href="{{ route('developer.system.health') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">Docs</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Ecosystem</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Pricing</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Cloud on AWS</a></li>
                    </ul>
                </div>
            </div>

            <!-- Kolom 3: Solutions & Integrations (Bertumpuk) -->
            <div class="space-y-10">
                <!-- Blok Atas: Solutions -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Solutions</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Retail Boutiques</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Enterprises</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">MSME / UMKM</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Multi-outlet Retail</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Customers support</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Government</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Terms &amp; Policies</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a @if(Route::has('privacy')) href="{{ route('privacy') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">Privacy Policy</a></li>
                        <li><a @if(Route::has('cookie-policy')) href="{{ route('cookie-policy') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">Cookie Policy</a></li>
                        <li><a @if(Route::has('terms')) href="{{ route('terms') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">Terms of Service</a></li>
                        <li><a @if(Route::has('gdpr')) href="{{ route('gdpr') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">GDPR Compliance</a></li>
                    </ul>
                </div>
            </div>

            <!-- Kolom 4: Resources & Help & Security (Bertumpuk) -->
            <div class="space-y-10">
                <!-- Blok Atas: Resources -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Resources</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a @if(Route::has('blog.index')) href="{{ route('blog.index') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">Blog</a></li>
                        <li><a @if(Route::has('guides')) href="{{ route('guides') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">User Guides</a></li>
                        <li><a @if(Route::has('faq')) href="{{ route('faq') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">Community</a></li>
                        <li><a @if(Route::has('faq')) href="{{ route('faq') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">Customer Stories</a></li>
                        <li><a @if(Route::has('faq')) href="{{ route('faq') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">Service Desk</a></li>
                        <li><a @if(Route::has('faq')) href="{{ route('faq') }}" @else href="#" @endif class="text-slate-400 hover:text-white transition-colors duration-150">FAQ Center</a></li>
                    </ul>
                </div>
                <!-- Blok Bawah: Help & Security -->
            </div>

            <!-- Kolom 5: Company & Terms and policies (Bertumpuk) -->
            <div class="space-y-10">
                <!-- Blok Atas: Company -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Company</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">CoreSite</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Careers</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">News</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Policy</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Security and Compliance</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors duration-150">Transparency</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="py-8 border-t border-slate-900 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left">
                <p class="text-xs sm:text-sm text-slate-500">
                    &copy; {{ date('Y') }} <span class="font-medium text-slate-300">CoreSite</span>. All rights reserved.
                </p>
            </div>

            <div class="flex items-center gap-4 text-xs text-slate-500">
                <span class="flex items-center gap-1.5">
                    <span class="inline-block w-1.5 h-1.5 bg-[#00D27A] rounded-full animate-pulse"></span>
                    Beta Release
                </span>
                <span>v0.107.43</span>
            </div>
        </div>
    </div>
</footer>