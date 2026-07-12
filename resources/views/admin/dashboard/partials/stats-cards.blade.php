{{-- resources/views/admin/dashboard/partials/stats-cards.blade.php --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Revenue Card -->
    <div class="card hover:shadow-lg transition-shadow group">
        <div class="card-body">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-1">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">
                        Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}
                    </p>
                    <div class="flex items-center gap-1 mt-2">
                        @php
                            $revenueTrend = $stats['revenue_trend'] ?? 0;
                        @endphp
                        @if($revenueTrend > 0)
                            <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span class="text-xs text-success">+{{ number_format($revenueTrend, 1) }}%</span>
                        @elseif($revenueTrend < 0)
                            <svg class="w-4 h-4 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                            </svg>
                            <span class="text-xs text-error">{{ number_format($revenueTrend, 1) }}%</span>
                        @else
                            <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>
                            </svg>
                            <span class="text-xs text-text-secondary">0%</span>
                        @endif
                        <span class="text-xs text-text-secondary dark:text-text-dark-secondary">dari bulan lalu</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition-colors">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Products Sold Card -->
    <div class="card hover:shadow-lg transition-shadow group">
        <div class="card-body">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-1">Produk Terjual</p>
                    <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">
                        {{ number_format($stats['total_products_sold'] ?? 0) }}
                    </p>
                    <div class="flex items-center gap-1 mt-2">
                        @php
                            $productsTrend = $stats['products_trend'] ?? 0;
                        @endphp
                        @if($productsTrend > 0)
                            <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span class="text-xs text-success">+{{ number_format($productsTrend, 1) }}%</span>
                        @elseif($productsTrend < 0)
                            <svg class="w-4 h-4 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                            </svg>
                            <span class="text-xs text-error">{{ number_format($productsTrend, 1) }}%</span>
                        @else
                            <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>
                            </svg>
                            <span class="text-xs text-text-secondary">0%</span>
                        @endif
                        <span class="text-xs text-text-secondary dark:text-text-dark-secondary">dari bulan lalu</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition-colors">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Transactions Card -->
    <div class="card hover:shadow-lg transition-shadow group">
        <div class="card-body">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-1">Total Transaksi</p>
                    <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">
                        {{ number_format($stats['total_transactions'] ?? 0) }}
                    </p>
                    <div class="flex items-center gap-1 mt-2">
                        @php
                            $transactionsTrend = $stats['transactions_trend'] ?? 0;
                        @endphp
                        @if($transactionsTrend > 0)
                            <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span class="text-xs text-success">+{{ number_format($transactionsTrend, 1) }}%</span>
                        @elseif($transactionsTrend < 0)
                            <svg class="w-4 h-4 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                            </svg>
                            <span class="text-xs text-error">{{ number_format($transactionsTrend, 1) }}%</span>
                        @else
                            <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>
                            </svg>
                            <span class="text-xs text-text-secondary">0%</span>
                        @endif
                        <span class="text-xs text-text-secondary dark:text-text-dark-secondary">dari bulan lalu</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition-colors">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Average Transaction Card -->
    <div class="card hover:shadow-lg transition-shadow group">
        <div class="card-body">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-1">Rata-rata Transaksi</p>
                    <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">
                        Rp {{ number_format($stats['average_transaction'] ?? 0, 0, ',', '.') }}
                    </p>
                    <div class="flex items-center gap-1 mt-2">
                        @php
                            $avgTrend = $stats['average_trend'] ?? 0;
                        @endphp
                        @if($avgTrend > 0)
                            <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span class="text-xs text-success">+{{ number_format($avgTrend, 1) }}%</span>
                        @elseif($avgTrend < 0)
                            <svg class="w-4 h-4 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                            </svg>
                            <span class="text-xs text-error">{{ number_format($avgTrend, 1) }}%</span>
                        @else
                            <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>
                            </svg>
                            <span class="text-xs text-text-secondary">0%</span>
                        @endif
                        <span class="text-xs text-text-secondary dark:text-text-dark-secondary">dari bulan lalu</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition-colors">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stock Alerts -->
@if(($stats['low_stock_count'] ?? 0) > 0 || ($stats['out_of_stock_count'] ?? 0) > 0)
<div class="alert alert-warning flex items-center gap-3">
    <svg class="w-5 h-5 flex-shrink-0 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
    <div>
        @if(($stats['low_stock_count'] ?? 0) > 0)
            <span>{{ $stats['low_stock_count'] }} produk stok menipis</span>
        @endif
        @if(($stats['out_of_stock_count'] ?? 0) > 0)
            @if(($stats['low_stock_count'] ?? 0) > 0) & @endif
            <span>{{ $stats['out_of_stock_count'] }} produk habis</span>
        @endif
        <a href="{{ route('admin.products.index') }}" class="btn btn-ghost btn-sm">
            Kelola Stok →
        </a>
    </div>
</div>
@endif