{{-- resources/views/landing/partials/hero.blade.php --}}
<section class="relative overflow-hidden py-20 lg:py-28 dot-grid">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Main centered container -->
        <div class="flex flex-col items-center text-center max-w-4xl mx-auto">
            <!-- Hero Heading -->
            <h1 class="text-heading-1 font-bold mb-6 tracking-tight leading-tight animate-slide-up">
                Kelola Toko & Kasir
                <span class="text-accent text-emerald-400">Otomatis</span>
                Dalam Satu Platform
            </h1>

            <!-- Hero Subtitle -->
            <p class="text-body-lg text-text-secondary text-center max-w-2xl mx-auto mb-8 animate-slide-up">
                Platform web toko dan kasir otomatis untuk UMKM. Dapatkan dashboard admin
                dan halaman e-catalog profesional dalam hitungan menit. Gratis selamanya!
            </p>

            <!-- CTA Buttons -->
            <div class="flex items-center justify-center gap-4 mb-8 animate-slide-up">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    Mulai Gratis
                </a>
                <a href="#features" class="btn btn-secondary">
                    Lihat Fitur
                </a>
            </div>

            <!-- Trust Markers -->
            <div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-4 text-caption text-text-secondary mb-16 animate-slide-up">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tanpa kartu kredit
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Batal kapan saja
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Support 24/7
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Data terenkripsi
                </span>
            </div>
        </div>

        <!-- Dashboard Mockup (under CTA) -->
        <div class="mt-8 w-full max-w-5xl mx-auto relative px-4 animate-slide-up">
            <!-- Glow background effect -->
            <div class="absolute -inset-10 bg-accent/10 blur-3xl rounded-full opacity-65 -z-10"></div>
            
            <!-- Mockup Card -->
            <div class="card p-0 overflow-hidden shadow-2xl border border-slate-800 dark:border-slate-800 bg-[#0C0D0F] text-[#A0A5B0]">
                <!-- Browser Header -->
                <div class="bg-[#141618] border-b border-slate-800 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-error"></div>
                        <div class="w-3 h-3 rounded-full bg-warning"></div>
                        <div class="w-3 h-3 rounded-full bg-success"></div>
                        <div class="ml-4 text-xs font-semibold text-[#A0A5B0] flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-success animate-pulse"></span>
                            Dashboard Admin
                        </div>
                    </div>
                    <!-- Address Bar -->
                    <div class="hidden sm:flex items-center gap-2 text-[11px] bg-[#0C0D0F] px-4 py-1.5 rounded-lg border border-slate-800/80 w-64 justify-center text-[#6C757D]">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        coresite.id/admin/dashboard
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-slate-700"></div>
                        <div class="w-1.5 h-1.5 rounded-full bg-slate-700"></div>
                    </div>
                </div>

                <!-- Mockup Content layout -->
                <div class="flex h-[480px] md:h-[540px] text-left">
                    <!-- Sidebar Column -->
                    <aside class="w-48 bg-[#141618] border-r border-slate-800 p-4 hidden md:flex flex-col justify-between">
                        <div class="space-y-6">
                            <!-- Sidebar Brand -->
                            <div class="flex items-center gap-2 px-2">
                                <div class="w-6 h-6 bg-accent rounded-lg flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">C</span>
                                </div>
                                <span class="font-bold text-sm text-white">CoreSite</span>
                            </div>

                            <!-- Nav Links -->
                            <nav class="space-y-1">
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-2 mb-2">Admin</p>
                                <a href="#" class="flex items-center gap-2.5 px-2.5 py-2 text-xs font-semibold text-white bg-accent/10 border-l-2 border-accent rounded-r">
                                    <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/>
                                    </svg>
                                    Dashboard
                                </a>
                                <a href="#" class="flex items-center gap-2.5 px-2.5 py-2 text-xs font-semibold hover:text-white hover:bg-slate-800/50 rounded transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Discounts
                                </a>
                                <a href="#" class="flex items-center gap-2.5 px-2.5 py-2 text-xs font-semibold hover:text-white hover:bg-slate-800/50 rounded transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    Message
                                </a>
                                <a href="#" class="flex items-center gap-2.5 px-2.5 py-2 text-xs font-semibold hover:text-white hover:bg-slate-800/50 rounded transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    Harga
                                </a>
                                <a href="#" class="flex items-center gap-2.5 px-2.5 py-2 text-xs font-semibold hover:text-white hover:bg-slate-800/50 rounded transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    Customers
                                </a>
                            </nav>
                        </div>

                        <!-- System Links -->
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-2 mb-2">System</p>
                            <a href="#" class="flex items-center gap-2.5 px-2.5 py-2 text-xs font-semibold hover:text-white hover:bg-slate-800/50 rounded transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Settings
                            </a>
                        </div>
                    </aside>

                    <!-- Inner Grid Panel -->
                    <main class="flex-1 p-6 overflow-y-auto space-y-6">
                        <!-- Toolbar -->
                        <div class="flex items-center justify-between md:justify-end gap-4 border-b border-slate-800/50 pb-4">
                            <h2 class="text-xs font-semibold text-white md:hidden">Dashboard Admin</h2>
                            <div class="flex items-center gap-4">
                                <div class="relative p-1.5 rounded-full bg-slate-800/40 border border-slate-800 text-slate-400 hover:text-white cursor-pointer">
                                    <span class="absolute top-1 right-1 w-1.5 h-1.5 bg-accent rounded-full"></span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                </div>
                                <div class="flex items-center gap-2 cursor-pointer">
                                    <div class="w-6 h-6 rounded-full bg-accent/20 border border-accent flex items-center justify-center text-[10px] font-bold text-accent">
                                        JD
                                    </div>
                                    <span class="text-xs font-semibold text-[#A0A5B0] hidden sm:inline">John Doe</span>
                                </div>
                            </div>
                        </div>

                        <!-- Content Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Left Sub-Grid (Stat Cards + Bar Chart) -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Stat Cards -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <!-- Card 1 -->
                                    <div class="bg-[#141618] border border-slate-800/80 rounded-xl p-4 space-y-1">
                                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-wider">Total Account</p>
                                        <span class="text-lg font-bold text-white">$33,000</span>
                                    </div>
                                    <!-- Card 2 -->
                                    <div class="bg-[#141618] border border-slate-800/80 rounded-xl p-4 space-y-1">
                                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-wider">Total Price</p>
                                        <span class="text-lg font-bold text-white">$3,000</span>
                                    </div>
                                    <!-- Card 3 -->
                                    <div class="bg-[#141618] border border-slate-800/80 rounded-xl p-4 space-y-1">
                                        <p class="text-[9px] font-bold text-accent uppercase tracking-wider">Total Member</p>
                                        <span class="text-lg font-bold text-accent">$0,000</span>
                                    </div>
                                </div>

                                <!-- Bar Chart -->
                                <div class="bg-[#141618] border border-slate-800/80 rounded-xl p-5 space-y-4">
                                    <h3 class="text-[10px] font-bold text-white uppercase tracking-wider">Representation state</h3>
                                    <!-- Bars -->
                                    <div class="h-32 flex items-end justify-between gap-1 pt-4 border-b border-slate-800/50 border-l border-slate-800/50 pl-2 pb-1">
                                        <div class="w-full bg-accent/20 rounded-t transition" style="height: 45%;"></div>
                                        <div class="w-full bg-accent/25 rounded-t transition" style="height: 25%;"></div>
                                        <div class="w-full bg-accent/30 rounded-t transition" style="height: 60%;"></div>
                                        <div class="w-full bg-accent/40 rounded-t transition" style="height: 15%;"></div>
                                        <div class="w-full bg-accent/50 rounded-t transition" style="height: 85%;"></div>
                                        <div class="w-full bg-accent/60 rounded-t transition" style="height: 50%;"></div>
                                        <div class="w-full bg-accent/70 rounded-t transition" style="height: 70%;"></div>
                                        <div class="w-full bg-accent/80 rounded-t transition" style="height: 35%;"></div>
                                        <div class="w-full bg-accent/90 rounded-t transition" style="height: 95%;"></div>
                                        <div class="w-full bg-accent/100 rounded-t transition" style="height: 65%;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Sub-Grid (Total Summary + Customer Status) -->
                            <div class="space-y-6">
                                <!-- Total Summary doughnut mock -->
                                <div class="bg-[#141618] border border-slate-800/80 rounded-xl p-5 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-[10px] font-bold text-white uppercase tracking-wider">Total Summary</h3>
                                        <span class="text-[9px] font-bold text-accent bg-accent/10 px-2 py-0.5 rounded cursor-pointer">Change</span>
                                    </div>
                                    <div class="flex items-center justify-center py-2">
                                        <div class="relative w-24 h-24 flex items-center justify-center">
                                            <div class="absolute inset-0 rounded-full border-4 border-slate-800/80"></div>
                                            <div class="absolute inset-0 rounded-full border-4 border-accent border-r-transparent border-b-transparent rotate-45"></div>
                                            <div class="text-center z-10">
                                                <span class="text-sm font-bold text-white">54.20%</span>
                                                <p class="text-[8px] text-slate-500">Total</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Legend list -->
                                    <div class="space-y-1.5 text-[10px]">
                                        <div class="flex justify-between items-center">
                                            <span class="text-slate-400 flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                                                Cash
                                            </span>
                                            <span class="font-semibold text-white">$1,700</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-slate-400 flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#00D27A]"></span>
                                                Sebcreation
                                            </span>
                                            <span class="font-semibold text-white">$11,202</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-slate-400 flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-warning"></span>
                                                Tax
                                            </span>
                                            <span class="font-semibold text-white">5.23%</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Customer Status -->
                                <div class="bg-[#141618] border border-slate-800/80 rounded-xl p-5 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-[10px] font-bold text-white uppercase tracking-wider">Customer Status</h3>
                                        <span class="text-[9px] text-slate-500 hover:text-white cursor-pointer">View All</span>
                                    </div>
                                    <div class="space-y-3 text-xs">
                                        <div class="space-y-1">
                                            <div class="flex justify-between text-[10px]">
                                                <span class="text-slate-400">Total value</span>
                                                <span class="font-bold text-white">Rp 115.000</span>
                                            </div>
                                            <div class="w-full bg-slate-800 h-1 rounded-full overflow-hidden">
                                                <div class="bg-accent h-full rounded-full" style="width: 75%;"></div>
                                            </div>
                                        </div>
                                        <div class="space-y-1">
                                            <div class="flex justify-between text-[10px]">
                                                <span class="text-slate-400">Total active</span>
                                                <span class="font-bold text-white">Rp 300.000</span>
                                            </div>
                                            <div class="w-full bg-slate-800 h-1 rounded-full overflow-hidden">
                                                <div class="bg-[#00D27A] h-full rounded-full" style="width: 45%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>

            <!-- Floating Chat Widget Mockup (perfectly matches image) -->
            <div class="absolute -bottom-6 right-2 sm:right-8 md:right-12 z-30 flex items-end gap-3 scale-90 sm:scale-100 animate-slide-up">
                <!-- Chat Bubble -->
                <div class="bg-[#0C0D0F]/95 border border-accent/40 rounded-2xl p-4 max-w-[280px] shadow-2xl backdrop-blur-md text-left">
                    <p class="text-xs text-white leading-relaxed">
                        Ada pertanyaan? <span class="text-accent font-semibold">CoreSite AI</span> siap membantu <span class="text-slate-500">(ketik pertanyaan Anda...)</span>
                    </p>
                </div>
                <!-- Chat Toggle Button -->
                <div class="w-12 h-12 rounded-full bg-accent hover:bg-accent-hover flex items-center justify-center shadow-lg shadow-accent/30 cursor-pointer hover:scale-105 transition-all shrink-0">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4h16v12H7l-3 3V4Z"/>
                        <path d="M8.5 9.5h7M8.5 12.5h4" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>