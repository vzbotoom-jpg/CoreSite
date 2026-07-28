{{-- resources/views/landing/pricing.blade.php --}}
@extends('layouts.landing')

@section('title', 'Harga - CoreSite')
@section('description', 'Pilih paket harga berlangganan CoreSite yang paling tepat untuk pertumbuhan bisnis UMKM Anda.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="pricingToggle()">
    <!-- Header -->
    <div class="text-center mb-12">
        <span class="inline-flex items-center gap-2 px-3 py-1 bg-accent/10 text-accent text-sm font-medium rounded-full">
            💰 Investasi Terbaik UMKM
        </span>
        <h1 class="text-4xl md:text-5xl font-bold text-text-primary dark:text-text-dark-primary mb-4 mt-4 leading-tight">
            Pilih Paket Berlangganan yang <span class="text-accent text-emerald-400">Tepat</span>
        </h1>
        <p class="text-lg text-text-secondary dark:text-text-dark-secondary max-w-2xl mx-auto">
            Mulai gratis selamanya, kembangkan bisnis Anda bersama kasir otomatis CoreSite.
        </p>
    </div>

    <!-- Annual vs Monthly Switch (Alpine) -->
    <div class="flex items-center justify-center gap-4 mb-12">
        <span class="text-sm font-semibold" :class="!annual ? 'text-text-primary dark:text-text-dark-primary' : 'text-text-secondary'">Bayar Bulanan</span>
        <button @click="annual = !annual" class="relative w-12 h-6 bg-accent rounded-full transition-colors duration-200 focus:outline-none">
            <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform duration-200" :class="annual ? 'translate-x-6' : ''"></span>
        </button>
        <span class="text-sm font-semibold flex items-center gap-1.5" :class="annual ? 'text-text-primary dark:text-text-dark-primary' : 'text-text-secondary'">
            Bayar Tahunan
            <span class="badge badge-success text-[10px] font-bold py-0.5 px-2 bg-emerald-500/10 text-emerald-500 rounded-full border border-emerald-500/20">Hemat 20%</span>
        </span>
    </div>
    
    <!-- Trust banner -->
    <div class="max-w-3xl mx-auto mb-12">
        <div class="flex flex-wrap items-center justify-center gap-6 bg-accent/5 border border-accent/20 rounded-xl px-6 py-4 text-xs font-semibold text-text-secondary">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Garansi 14 hari uang kembali
            </span>
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Pembayaran aman & terenkripsi
            </span>
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Batal kapan saja, tanpa biaya tersembunyi
            </span>
        </div>
    </div>

    <!-- Pricing Cards -->
    <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto mb-20">
        <!-- Starter Plan -->
        <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border hover:shadow-lg transition-all flex flex-col justify-between h-full">
            <div class="card-body p-6 text-center">
                <div class="mb-4">
                    <span class="px-3 py-1 bg-light-surface dark:bg-dark-bg text-xs font-bold rounded-full">Starter (UMKM)</span>
                </div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-2">Starter</h3>
                <div class="text-4xl font-extrabold text-accent mb-1">Rp70.000</div>
                <p class="text-xs text-text-secondary dark:text-text-dark-secondary mb-6">Selamanya Gratis</p>
                <ul class="space-y-3.5 text-left mb-8 text-xs font-semibold text-text-secondary dark:text-text-dark-secondary">
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> 1 Toko / Cabang
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> Maksimal 100 produk
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> Laporan transaksi harian
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> E-catalog publik toko
                    </li>
                    <li class="flex items-center gap-2 opacity-40">
                        <span>✖</span> Ekspor data (Excel / PDF)
                    </li>
                </ul>
            </div>
            <div class="p-6 pt-0">
                <a href="{{ route('register') }}" class="btn btn-secondary w-full text-xs font-bold py-2.5 rounded-xl">Mulai Gratis</a>
            </div>
        </div>
        
        <!-- Business Plan -->
        <div class="card bg-white dark:bg-dark-surface border-2 border-accent shadow-lg relative flex flex-col justify-between h-full">
            <div class="absolute -top-3.5 left-1/2 transform -translate-x-1/2 bg-accent text-white px-4 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                Sangat Populer
            </div>
            <div class="card-body p-6 text-center">
                <div class="mb-4">
                    <span class="px-3 py-1 bg-accent/10 text-accent text-xs font-bold rounded-full">Best Value</span>
                </div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-2">Business</h3>
                <div class="text-4xl font-extrabold text-accent mb-1">Rp200.000</div>
                <p class="text-xs text-text-secondary dark:text-text-dark-secondary mb-6">Mendapatkan</p>
                <div class="text-4xl font-extrabold text-accent mb-1" x-text="annual ? 'Rp119.000' : 'Rp149.000'"></div>
                <p class="text-xs text-text-secondary dark:text-text-dark-secondary mb-6" x-text="annual ? '/bulan (ditagih tahunan)' : '/bulan'"></p>
                <ul class="space-y-3.5 text-left mb-8 text-xs font-semibold text-text-secondary dark:text-text-dark-secondary">
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> 1 Toko / Cabang
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> Unlimited produk
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> Laporan lengkap & laba rugi
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> E-catalog publik toko
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> Ekspor data (Excel / PDF)
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> Tambah hingga 3 kasir/staf
                    </li>
                </ul>
            </div>
            <div class="p-6 pt-0">
                <a href="{{ route('register') }}" class="btn btn-primary w-full text-xs font-bold py-2.5 rounded-xl shadow-md shadow-accent/20">Pilih Business</a>
            </div>
        </div>
        
        <!-- Enterprise Plan -->
        <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border hover:shadow-lg transition-all flex flex-col justify-between h-full">
            <div class="card-body p-6 text-center">
                <div class="mb-4">
                    <span class="px-3 py-1 bg-accent/10 text-accent text-xs font-bold rounded-full">Multi-Outlet</span>
                </div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-2">Enterprise</h3>
                <div class="text-4xl font-extrabold text-accent mb-1">Rp599.000</div>
                <p class="text-xs text-text-secondary dark:text-text-dark-secondary mb-6">Selamanya Gratis</p>
                <div class="text-4xl font-extrabold text-accent mb-1" x-text="annual ? 'Rp399.000' : 'Rp499.000'"></div>
                <p class="text-xs text-text-secondary dark:text-text-dark-secondary mb-6" x-text="annual ? '/bulan (ditagih tahunan)' : '/bulan'"></p>
                <ul class="space-y-3.5 text-left mb-8 text-xs font-semibold text-text-secondary dark:text-text-dark-secondary">
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> Hingga 5 Toko / Cabang
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> Unlimited produk
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> Laporan audit lengkap (Advanced)
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> E-catalog premium
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> Hak akses API kustom
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-500">✔</span> Custom domain website toko
                    </li>
                </ul>
            </div>
            <div class="p-6 pt-0">
                <a href="{{ route('contact') }}" class="btn btn-secondary w-full text-xs font-bold py-2.5 rounded-xl">Hubungi Kami</a>
            </div>
        </div>
    </div>
    
    <!-- Complete Feature Comparison Matrix -->
    <div class="max-w-4xl mx-auto">
        <h2 class="text-xl font-bold text-text-primary dark:text-text-dark-primary text-center mb-8 uppercase tracking-wider">
            Matriks Perbandingan Fitur Paket
        </h2>
        <div class="overflow-x-auto rounded-xl border border-light-border dark:border-dark-border shadow-xs">
            <table class="w-full text-left bg-white dark:bg-dark-surface text-xs font-semibold text-text-secondary">
                <thead>
                    <tr class="bg-light-bg/60 dark:bg-dark-bg/60 border-b border-light-border dark:border-dark-border text-[10px] uppercase font-bold text-text-secondary">
                        <th class="px-6 py-4">Fitur Utama</th>
                        <th class="px-6 py-4">Starter</th>
                        <th class="px-6 py-4 text-accent">Business</th>
                        <th class="px-6 py-4">Enterprise</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-light-border dark:divide-dark-border">
                    <tr>
                        <td class="px-6 py-3.5 text-text-primary dark:text-text-dark-primary font-bold">Kapasitas Produk</td>
                        <td class="px-6 py-3.5">Maks 100</td>
                        <td class="px-6 py-3.5 text-accent font-bold">Tanpa Batas</td>
                        <td class="px-6 py-3.5">Tanpa Batas</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 text-text-primary dark:text-text-dark-primary font-bold">Jumlah Cabang Toko</td>
                        <td class="px-6 py-3.5">1 Toko</td>
                        <td class="px-6 py-3.5 text-accent font-bold">1 Toko</td>
                        <td class="px-6 py-3.5">Hingga 5 Cabang</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 text-text-primary dark:text-text-dark-primary font-bold">Akses Akun Kasir / Staf</td>
                        <td class="px-6 py-3.5">Hanya Pemilik</td>
                        <td class="px-6 py-3.5 text-accent font-bold">Maks 3 Staf</td>
                        <td class="px-6 py-3.5">Tanpa Batas</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 text-text-primary dark:text-text-dark-primary font-bold">Laporan Laba Rugi</td>
                        <td class="px-6 py-3.5">Sederhana</td>
                        <td class="px-6 py-3.5 text-accent font-bold">Lengkap & Detail</td>
                        <td class="px-6 py-3.5">Ekstra Detail + Audit</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 text-text-primary dark:text-text-dark-primary font-bold">Ekspor Excel / PDF</td>
                        <td class="px-6 py-3.5">✖</td>
                        <td class="px-6 py-3.5 text-accent font-bold">✔</td>
                        <td class="px-6 py-3.5">✔</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 text-text-primary dark:text-text-dark-primary font-bold">Custom Domain Toko</td>
                        <td class="px-6 py-3.5">✖</td>
                        <td class="px-6 py-3.5 text-accent font-bold">✖</td>
                        <td class="px-6 py-3.5">✔</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function pricingToggle() {
    return {
        annual: false
    }
}
</script>
@endsection