{{-- resources/views/catalog/account/index.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Dashboard - Akun Saya')

@section('content')
<div x-data="accountDashboard()" x-init="init()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-accent/10 via-accent/5 to-transparent rounded-2xl p-6 mb-8 border border-accent/20">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-accent/20 rounded-full flex items-center justify-center">
                    <span class="text-2xl font-bold text-accent">B</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">
                        Selamat Datang, Budi Santoso! 👋
                    </h1>
                    <p class="text-text-secondary dark:text-text-dark-secondary">
                        Senang melihat Anda kembali. Berikut ringkasan aktivitas terakhir Anda.
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-accent/10 text-accent text-sm rounded-full border border-accent/20">
                    Member since Jun 2026
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="card hover:shadow-lg transition-all duration-300 group">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Total Pesanan</p>
                        <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1">12</p>
                        <p class="text-xs text-success mt-1">↑ 8.5% dari bulan lalu</p>
                    </div>
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition-colors">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-light-border/40 dark:border-dark-border/40 flex justify-between text-xs">
                    <span class="text-text-secondary">Selesai: <span class="text-success font-medium">8</span></span>
                    <span class="text-text-secondary">Pending: <span class="text-warning font-medium">3</span></span>
                    <span class="text-text-secondary">Dibatalkan: <span class="text-error font-medium">1</span></span>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-all duration-300 group">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Total Belanja</p>
                        <p class="text-2xl font-bold text-accent mt-1">Rp 2.850.000</p>
                        <p class="text-xs text-success mt-1">↑ 12.3% dari bulan lalu</p>
                    </div>
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition-colors">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-all duration-300 group">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Wishlist</p>
                        <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1">8</p>
                        <p class="text-xs text-text-secondary mt-1">3 produk baru ditambahkan</p>
                    </div>
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition-colors">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-light-border/40 dark:border-dark-border/40">
                    <a href="{{ route('catalog.account.wishlist') }}" class="text-xs text-accent hover:underline flex items-center gap-1">
                        Lihat Wishlist →
                    </a>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-all duration-300 group">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Ulasan</p>
                        <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1">15</p>
                        <p class="text-xs text-text-secondary mt-1">⭐ 4.8 rata-rata rating</p>
                    </div>
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition-colors">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Quick Actions -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 card">
            <div class="card-header flex justify-between items-center">
                <div>
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Pesanan Terbaru</h3>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">3 pesanan terakhir</p>
                </div>
                <a href="{{ route('catalog.account.orders') }}" class="text-accent hover:text-accent-hover text-sm flex items-center gap-1 transition-colors">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-light-border/40 dark:border-dark-border/40">
                            <th class="text-left px-4 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Order ID</th>
                            <th class="text-left px-4 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Tanggal</th>
                            <th class="text-left px-4 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Total</th>
                            <th class="text-left px-4 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Status</th>
                            <th class="text-left px-4 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-light-border/40 dark:border-dark-border/40 hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition-colors">
                            <td class="px-4 py-3">
                                <span class="font-mono text-sm text-text-primary dark:text-text-dark-primary">#ORD-2026-001</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-secondary dark:text-text-dark-secondary">17 Jun 2026</td>
                            <td class="px-4 py-3 font-semibold text-accent">Rp 149.000</td>
                            <td class="px-4 py-3">
                                <span class="badge badge-warning text-xs">Pending</span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="#" class="text-accent hover:text-accent-hover text-sm transition-colors">Detail</a>
                            </td>
                        </tr>
                        <tr class="border-b border-light-border/40 dark:border-dark-border/40 hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition-colors">
                            <td class="px-4 py-3">
                                <span class="font-mono text-sm text-text-primary dark:text-text-dark-primary">#ORD-2026-002</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-secondary dark:text-text-dark-secondary">15 Jun 2026</td>
                            <td class="px-4 py-3 font-semibold text-accent">Rp 75.000</td>
                            <td class="px-4 py-3">
                                <span class="badge badge-success text-xs">Selesai</span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="#" class="text-accent hover:text-accent-hover text-sm transition-colors">Detail</a>
                            </td>
                        </tr>
                        <tr class="hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition-colors">
                            <td class="px-4 py-3">
                                <span class="font-mono text-sm text-text-primary dark:text-text-dark-primary">#ORD-2026-003</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-secondary dark:text-text-dark-secondary">12 Jun 2026</td>
                            <td class="px-4 py-3 font-semibold text-accent">Rp 220.000</td>
                            <td class="px-4 py-3">
                                <span class="badge badge-error text-xs">Dibatalkan</span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="#" class="text-accent hover:text-accent-hover text-sm transition-colors">Detail</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="space-y-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Aksi Cepat</h3>
                </div>
                <div class="card-body space-y-2">
                    <a href="{{ route('catalog.store') }}" class="btn btn-primary w-full gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6"/>
                        </svg>
                        Belanja Sekarang
                    </a>
                    <a href="{{ route('catalog.account.orders') }}" class="btn btn-outline w-full gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Lihat Pesanan
                    </a>
                    <a href="{{ route('catalog.account.wishlist') }}" class="btn btn-outline w-full gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        Wishlist (8)
                    </a>
                    <a href="{{ route('catalog.account.profile') }}" class="btn btn-outline w-full gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Edit Profil
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Aktivitas Terbaru</h3>
                </div>
                <div class="card-body space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-accent/10 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-text-primary dark:text-text-dark-primary">Pesanan #ORD-2026-001 berhasil dibuat</p>
                            <p class="text-xs text-text-secondary dark:text-text-dark-secondary">2 jam yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-success/10 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-text-primary dark:text-text-dark-primary">Pesanan #ORD-2026-002 selesai</p>
                            <p class="text-xs text-text-secondary dark:text-text-dark-secondary">5 jam yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-warning/10 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-text-primary dark:text-text-dark-primary">Produk baru ditambahkan ke wishlist</p>
                            <p class="text-xs text-text-secondary dark:text-text-dark-secondary">1 hari yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function accountDashboard() {
    return {
        init() {
            // Auto refresh or any initialization
        }
    }
}
</script>
@endpush
@endsection