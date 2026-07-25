{{-- resources/views/admin/dashboard/partials/stats-cards.blade.php --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Card 1: Total Revenue -->
    <div class="card hover:shadow-lg transition-all duration-200 group bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
        <div class="card-body p-6">
            <div class="flex justify-between items-start">
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
                        Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}
                    </p>
                    <div class="flex items-center gap-1.5 mt-2">
                        @php
                            $revenueTrend = $stats['revenue_trend'] ?? 0;
                        @endphp
                        @if($revenueTrend > 0)
                            <span class="flex items-center text-xs font-semibold text-emerald-500 bg-emerald-500/10 px-1.5 py-0.5 rounded">
                                <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                {{ number_format($revenueTrend, 1) }}%
                            </span>
                        @elseif($revenueTrend < 0)
                            <span class="flex items-center text-xs font-semibold text-rose-500 bg-rose-500/10 px-1.5 py-0.5 rounded">
                                <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                                </svg>
                                {{ number_format($revenueTrend, 1) }}%
                            </span>
                        @else
                            <span class="flex items-center text-xs font-semibold text-text-secondary bg-light-surface dark:bg-dark-surface px-1.5 py-0.5 rounded">
                                <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 12h14"/>
                                </svg>
                                0%
                            </span>
                        @endif
                        <span class="text-[11px] text-text-secondary dark:text-text-dark-secondary">vs bulan lalu</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition-all duration-200 shadow-sm">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card 2: Total Transactions -->
    <div class="card hover:shadow-lg transition-all duration-200 group bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
        <div class="card-body p-6">
            <div class="flex justify-between items-start">
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider">Total Transaksi</p>
                    <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
                        {{ number_format($stats['total_transactions'] ?? 0) }} Transaksi
                    </p>
                    <p class="text-[11px] text-text-secondary dark:text-text-dark-secondary mt-2 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 11h.01M12 14h.01M15 11h.01M15 14h.01M12 7H9v2h3V7zm3-3H9v2h6V4z"/>
                        </svg>
                        Rata-rata Rp {{ number_format($stats['average_transaction'] ?? 0, 0, ',', '.') }}/transaksi
                    </p>
                </div>
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition-all duration-200 shadow-sm">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card 3: Volume Penjualan -->
    <div class="card hover:shadow-lg transition-all duration-200 group bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
        <div class="card-body p-6">
            <div class="flex justify-between items-start">
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider">Volume Penjualan</p>
                    <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
                        {{ number_format($stats['total_products_sold'] ?? 0) }} pcs
                    </p>
                    @php
                        $dominantProduct = 'Belum ada data';
                        if (!empty($topProducts) && !($topProducts instanceof \__PHP_Incomplete_Class)) {
                            $first = null;
                            if (is_iterable($topProducts)) {
                                foreach ($topProducts as $item) {
                                    $first = $item;
                                    break;
                                }
                            } elseif (is_array($topProducts) && isset($topProducts[0])) {
                                $first = $topProducts[0];
                            }

                            if ($first && !($first instanceof \__PHP_Incomplete_Class)) {
                                if (is_object($first)) {
                                    $dominantProduct = $first->name ?? 'Belum ada data';
                                } elseif (is_array($first)) {
                                    $dominantProduct = $first['name'] ?? 'Belum ada data';
                                }
                            }
                        }
                    @endphp
                    <p class="text-[11px] text-text-secondary dark:text-text-dark-secondary mt-2 truncate max-w-[180px]" title="Dominan: {{ $dominantProduct }}">
                        <span class="text-emerald-500 font-semibold">Dominan:</span> {{ $dominantProduct }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition-all duration-200 shadow-sm">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card 4: Estimasi Laba Bersih -->
    <div class="card hover:shadow-lg transition-all duration-200 group bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
        <div class="card-body p-6">
            <div class="flex justify-between items-start">
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider">Estimasi Laba Bersih</p>
                    <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
                        Rp {{ number_format(($stats['total_revenue'] ?? 0) * 0.25, 0, ',', '.') }}
                    </p>
                    <p class="text-[11px] text-text-secondary dark:text-text-dark-secondary mt-2 flex items-center gap-1.5">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        Estimasi 25% Net Margin
                    </p>
                </div>
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition-all duration-200 shadow-sm">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
