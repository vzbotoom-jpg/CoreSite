{{-- resources/views/layouts/partials/footer.blade.php --}}
<footer class="bg-light-bg dark:bg-dark-bg border-t border-light-border dark:border-dark-border mt-20 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Footer Content -->
        <div class="py-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-[2fr_1fr_1fr_1fr_1fr] gap-8 lg:gap-6">
            <!-- Brand Column -->
            <div class="col-span-1 md:col-span-1 lg:col-span-1 max-w-xs">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 bg-accent rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-xl">C</span>
                    </div>
                    <span class="font-bold text-xl text-text-primary dark:text-text-dark-primary transition-colors duration-200">CoreSite</span>
                </div>
                <p class="text-text-secondary dark:text-text-dark-secondary text-sm leading-relaxed transition-colors duration-200">
                    Platform toko online dan kasir otomatis. 
                    Dapatkan website toko + E-Catalog profesional dalam hitungan menit.
                </p>
                <div class="flex items-center gap-3 mt-4">
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200" aria-label="Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200" aria-label="Twitter">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200" aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200" aria-label="YouTube">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Product Column -->
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary mb-4 transition-colors duration-200">Products</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('features') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Feature</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">CoreSite Security</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Download app</a></li>
                    <li><a href="{{ route('pricing') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Pricing</a></li>
                    
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Log in to CoreSite</a></li>
                    <li><a href="{{ route('demo') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Demo</a></li>
                </ul>

                {{-- Sub-section: ditumpuk di bawah list Products dalam kolom yang sama,
                     mengikuti pola "Products -> Models" di footer Anthropic --}}
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary mb-4 mt-8 transition-colors duration-200">CoreSite Platform</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Overview</a></li>
                    <li><a href="{{ route('docs.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Docs</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Ecosystem</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Princing</a></li>
                </ul>
            </div>
            
            <!-- Company Column -->
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary mb-4 transition-colors duration-200">Solutions</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('about') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">About</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">CyberSecurity</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Government</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Customer Support</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Legal</a></li>
                </ul>

                {{-- Sub-section: ditumpuk di bawah list Solutions dalam kolom yang sama,
                     mengikuti pola "Solutions -> Claude Platform" di footer Anthropic --}}
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary mb-4 mt-8 transition-colors duration-200">Terms and policies</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('privacy') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Kebijakan Privasi</a></li>
                    <li><a href="{{ route('terms') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Syarat & Ketentuan</a></li>
                    <li><a href="{{ route('cookie-policy') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Cookie Policy</a></li>
                    <li><a href="{{ route('gdpr') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">GDPR</a></li>
                </ul>
            </div>
            
            <!-- Support Column -->
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary mb-4 transition-colors duration-200">Resources</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('blog.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Blog</a></li>
                    <li><a href="{{ route('guides') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Events</a></li>
                    <li><a href="{{ route('docs.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Comunity</a></li>
                    <li><a href="{{ route('docs.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Service Partners</a></li>
                    <li><a href="{{ route('docs.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Tutorials</a></li>
                    <li><a href="{{ route('faq') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Faq</a></li>

                </ul>
            </div>
            
            <!-- Legal Column -->
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary mb-4 transition-colors duration-200">Company</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">CoreSite</a></li>
                    <li><a href="{{ route('careers') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Careers</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">News</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Policy</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">CoreSite Constitution</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#00D27A] dark:hover:text-[#00D27A] transition-colors duration-200">Transparency</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="py-6 border-t border-light-border dark:border-dark-border flex flex-col sm:flex-row justify-between items-center gap-4 transition-colors duration-200">
            <div class="text-center sm:text-left">
                <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-200">
                    &copy; {{ date('Y') }} <span class="font-medium text-text-primary dark:text-text-dark-primary">CoreSite</span>. 
                    All rights reserved.
                </p>
            </div>
            <div class="flex items-center gap-4 text-xs">
                <span class="text-gray-500 dark:text-gray-400 transition-colors duration-200">
                    <span class="inline-block w-2 h-2 bg-[#00D27A] rounded-full mr-1.5 animate-pulse"></span>
                    Versi Beta
                </span>
                <span class="text-gray-500 dark:text-gray-400 transition-colors duration-200">
                    v0.107.43
                </span>
            </div>
        </div>
    </div>
</footer>